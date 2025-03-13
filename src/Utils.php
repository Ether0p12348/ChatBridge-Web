<?php
namespace Ethanrobins\Chatbridge;

use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;

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

    public static function init(): string
    {
        ob_start();
        ?>
        <link rel="stylesheet" href="/styles/global.css">
        <?php
        return ob_get_clean();
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