<?php
namespace Ethanrobins\Chatbridge;

use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;
use Ethanrobins\Chatbridge\Language\Lang;

/**
 * Utility class for general-purpose static methods.
 */
class Utils
{
    /**
     * Outputs a simple message indicating that Composer is set up correctly.
     *
     * @return void
     */
    public static function isWorking(): void
    {
        echo "Composer is working.";
    }

    public static function getStoredLang(): Lang
    {
        return (isset($_COOKIE['locale']) && Lang::fromLocale($_COOKIE['locale']) != Lang::UNKNOWN) ? Lang::fromLocale($_COOKIE['locale']) : Lang::fromLocale('en-US');
    }

    public static function headInit(): string
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/styles/global.css">
        <link rel="icon" href="/assets/chatbridge/icon.svg" type="image/svg">
        <?php
        return ob_get_clean();
    }

    public static function phpInit(): void
    {
        // locale uri checks
        if (!isset($_GET['lang'])) {
            $browserLocale = "en-US";
            if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $parts = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
                if (!empty($parts[0])) {
                    $browserLocale = str_replace('_', '-', trim($parts[0]));
                }
            }

            $possibleLang = Lang::fromLocale($browserLocale);

            if ($possibleLang === Lang::UNKNOWN) {
                $possibleLang = Lang::ENGLISH_US;
            }

            $localeStr = str_replace('-', '_', $possibleLang->getLocale());

            $originalRequestUri = $_SERVER['REQUEST_URI'];
            $qsPos = strpos($originalRequestUri, '?');
            $pathOnly = $originalRequestUri;
            $query = '';

            if ($qsPos !== false) {
                $pathOnly = substr($originalRequestUri, 0, $qsPos);
                $query = substr($originalRequestUri, $qsPos); // includes '?'
            }

            $pathOnly = ltrim($pathOnly, '/');

            $newUrl = '/' . $localeStr . '/' . $pathOnly . $query;

            header('Location: ' . $newUrl, true, 302);
            exit;
        } else {
            $requestedLocale = $_GET['lang'];

            $possibleLang = Lang::fromLocale(str_replace('_', '-', $requestedLocale));

            if ($possibleLang === Lang::UNKNOWN) {
                if ($possibleLang === Lang::UNKNOWN) {
                    $possibleLang = Lang::ENGLISH_US;
                    // Our fallback locale as used in the URL, e.g. "en-US" becomes "en_US"
                    $localeStr = str_replace('-', '_', $possibleLang->getLocale());

                    // Parse current URL:
                    $originalRequestUri = $_SERVER['REQUEST_URI'];
                    $parsedUrl = parse_url($originalRequestUri);
                    $path = $parsedUrl['path'] ?? '';
                    $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';

                    // Use a regex similar to your nginx rewrite to see if the first segment is locale-like.
                    // This pattern: 2 letters followed by an optional dash/underscore and 2-5 alphanum characters.
                    if (preg_match('#^/([a-zA-Z]{2}(?:[-_][a-zA-Z0-9]{0,5})?)(/.*)?$#', $path, $matches)) {
                        // $matches[1] is the invalid locale; $matches[2] is the rest of the path (may be empty)
                        $restPath = $matches[2] ?? '';
                    } else {
                        // If the path doesn't start with a locale-like segment, keep it intact.
                        $restPath = $path;
                    }

                    // Build the canonical URL with the fallback locale in place of the first segment.
                    $newUrl = '/' . $localeStr . '/' . ltrim($restPath, '/') . $query;
                    header('Location: ' . $newUrl, true, 302);
                    exit;
                }
            } else {
                $finalLocale = $possibleLang->getLocale();
                setcookie('locale', $finalLocale, [
                    'expires'  => time() + 31536000, // 1 year
                    'path'     => '/',
                    'httponly' => true,
                    'secure'   => true, // if you're using https
                    'samesite' => 'Lax',
                ]);
            }
        }
    }

    public static function displayErrors(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    /**
     * Reads and parses a JSON file from the given absolute file path.
     *
     * @param string $absoluteFilePath The absolute path to the JSON file.
     * @return array The parsed data from the JSON file as an associative array.
     * @throws DocumentationConfigurationException
     */
    public static function getJsonData(string $absoluteFilePath): array {
        if (!file_exists($absoluteFilePath)) {
            throw new DocumentationConfigurationException("File not found: " . $absoluteFilePath);
        }
        if (!is_readable($absoluteFilePath)) {
            throw new DocumentationConfigurationException("File is not readable: " . $absoluteFilePath);
        }

        $jsonContents = file_get_contents($absoluteFilePath);

        if ($jsonContents === false) {
            throw new DocumentationConfigurationException("Failed to read the JSON file: " . $absoluteFilePath);
        }

        $data = json_decode($jsonContents, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new DocumentationConfigurationException("Invalid JSON: " . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Get a .md file's respective configuration file
     * @param string $absoluteFilePath The absolute path to the .md file.
     * @return string The absolute path to the config file
     * @throws DocumentationConfigurationException
     */
    public static function getConfigPath(string $absoluteFilePath): string
    {
        $srcKeyword = "src/";
        $srcPos = strpos($absoluteFilePath, $srcKeyword);
        if ($srcPos === false) {
            throw new DocumentationConfigurationException("The path is outside of the root src/ directory.");
        }

        $afterSrc = substr($absoluteFilePath, $srcPos + strlen($srcKeyword));
        $parts = explode('/', $afterSrc);

        if (empty($parts[0])) {
            throw new DocumentationConfigurationException("This file does not belong to a specific documentation.");
        }

        $rootDir = $parts[0];
        return substr($absoluteFilePath, 0, $srcPos + strlen($srcKeyword) + strlen($rootDir)) . '/config.json';
    }

    public static function getLangModal(): string
    {
        // TODO: work on LanguageModal (language selector - uses cookies)
        ob_start();
        ?>
        <link rel="stylesheet" href="/styles/lang_modal.css">
        <?php
        return ob_get_clean();
    }
}