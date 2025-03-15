<?php
namespace Ethanrobins\Chatbridge;

use Ethanrobins\Chatbridge\Assets\SVG;
use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;
use Ethanrobins\Chatbridge\Exception\LanguageException;
use Ethanrobins\Chatbridge\Language\Lang;
use Ethanrobins\Chatbridge\Language\LangSet;

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
        if (isset($_GET['lang']) && isset($_COOKIE['locale']) && str_replace('_', '-', $_GET['lang']) === $_COOKIE['locale']) {
            return (Lang::fromLocale($_COOKIE['locale']) != Lang::UNKNOWN) ? Lang::fromLocale($_COOKIE['locale']) : Lang::fromLocale('en-US');
        } else if (!isset($_COOKIE['locale'])) {
            // cookies aren't supported by client (discord scraper or non-browser client)
            return Lang::fromLocale(str_replace('_', '-', $_GET['lang']) ?? 'en_US');
        }
        header('Location: ' . $_SERVER['REQUEST_URI'], true, 302);
        exit;
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
                    $localeStr = str_replace('-', '_', $possibleLang->getLocale());

                    $originalRequestUri = $_SERVER['REQUEST_URI'];
                    $parsedUrl = parse_url($originalRequestUri);
                    $path = $parsedUrl['path'] ?? '';
                    $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';

                    if (preg_match('#^/([a-zA-Z]{2}(?:[-_][a-zA-Z0-9]{0,5})?)(/.*)?$#', $path, $matches)) {
                        $restPath = $matches[2] ?? '';
                    } else {
                        $restPath = $path;
                    }

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

        Utils::displayErrors();
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

    public static function getLangModal(Lang $activeLang): string
    {
        $buttonTitle = new LangSet();
        try {
            $buttonTitle->set(Lang::BULGARIAN, "Преведи страницата");
            $buttonTitle->set(Lang::CHINESE_CHINA, "翻译页面");
            $buttonTitle->set(Lang::CHINESE_TAIWAN, "翻譯頁面");
            $buttonTitle->set(Lang::CROATIAN, "Prevedi stranicu");
            $buttonTitle->set(Lang::CZECH, "Přeložit stránku");
            $buttonTitle->set(Lang::DANISH, "Oversæt side");
            $buttonTitle->set(Lang::DUTCH, "Pagina vertalen");
            $buttonTitle->set(Lang::ENGLISH_UK, "Translate Page");
            $buttonTitle->set(Lang::ENGLISH_US, "Translate Page");
            $buttonTitle->set(Lang::FINNISH, "Käännä sivu");
            $buttonTitle->set(Lang::FRENCH, "Traduire la page");
            $buttonTitle->set(Lang::GERMAN, "Seite übersetzen");
            $buttonTitle->set(Lang::GREEK, "Μετάφραση σελίδας");
            $buttonTitle->set(Lang::HINDI, "पृष्ठ का अनुवाद करें");
            $buttonTitle->set(Lang::HUNGARIAN, "Oldal fordítása");
            $buttonTitle->set(Lang::INDONESIAN, "Terjemahkan Halaman");
            $buttonTitle->set(Lang::ITALIAN, "Traduci pagina");
            $buttonTitle->set(Lang::JAPANESE, "ページを翻訳");
            $buttonTitle->set(Lang::KOREAN, "페이지 번역");
            $buttonTitle->set(Lang::LITHUANIAN, "Išversti puslapį");
            $buttonTitle->set(Lang::NORWEGIAN, "Oversett side");
            $buttonTitle->set(Lang::POLISH, "Przetłumacz stronę");
            $buttonTitle->set(Lang::PORTUGUESE_BRAZILIAN, "Traduzir página");
            $buttonTitle->set(Lang::ROMANIAN_ROMANIA, "Traduce pagina");
            $buttonTitle->set(Lang::RUSSIAN, "Перевести страницу");
            $buttonTitle->set(Lang::SPANISH, "Traducir página");
            $buttonTitle->set(Lang::SPANISH_LATAM, "Traducir página");
            $buttonTitle->set(Lang::SWEDISH, "Översätt sida");
            $buttonTitle->set(Lang::THAI, "แปลหน้า");
            $buttonTitle->set(Lang::TURKISH, "Sayfayı Çevir");
            $buttonTitle->set(Lang::UKRAINIAN, "Перекласти сторінку");
            $buttonTitle->set(Lang::VIETNAMESE, "Dịch trang");
        } catch (LanguageException $e) {
            die($e->getMessage());
        }

        ob_start();
        ?>
        <link rel="stylesheet" href="/styles/lang_modal.css">

        <div class="lang_modal_container">
            <label title="<?php echo $buttonTitle->get($activeLang)->getString(); ?>" class="lang_modal_toggle_container" for="lang_modal_toggle_checkbox">
                <?php echo SVG::LANGUAGE->get("8vh", "8vh"); ?>
                <input type="checkbox" id="lang_modal_toggle_checkbox" hidden="hidden">
            </label>
            <div class="lang_modal_selector_container">
            <?php
            foreach (Lang::cases() as $l) {
                if ($l != Lang::UNKNOWN) {
                ?>
                <a class="lang_modal_selector<?php echo $l === $activeLang ? " active" : ""; ?>" href="<?php echo preg_replace('/\b' . preg_quote(str_replace('-', '_', $activeLang->getLocale()), '/') . '\b|' . preg_quote(str_replace('_', '-', $activeLang->getLocale()), '/') . '\b/', str_replace('-', '_', $l->getLocale()), $_SERVER['REQUEST_URI']); ?>">
                    <!-- TODO: Maybe make the entire link background a low-opacity, slightly blurred image of the country's flag with/without the icon -->
                    <div class="lang_modal_icon" style="background-image: url(<?php echo $l->getFlag(); ?>);"></div>
                    <div class="lang_modal_text_container">
                        <div class="lang_modal_text"><?php echo $l->getNativeName(); ?></div>
                        <div class="lang_modal_subtext"><?php echo $l->getLanguageNameInLanguage($activeLang); ?></div>
                    </div>
                </a>
                <?php
                }
            }
            ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}