<?php

namespace Ethanrobins\Chatbridge\Language;

use Ethanrobins\Chatbridge\Assets\SVG;
use Ethanrobins\Chatbridge\Exception\LanguageException;

/**
 * Utility class for Lang static methods.
 */
class LangDriver
{
    /**
     * @var bool {@link LangDriver::langInit()} should only be called once per page load. This ensures that's true.
     */
    static private bool $langInitCalled = false;
    /**
     * Gets whether {@link LangDriver::langInit()} has been called already using {@link LangDriver::$langInitCalled}.
     * @return bool
     */
    static private function langInitCalled(): bool
    {
        return self::$langInitCalled;
    }

    /**
     * @var bool {@link LangDriver::getLangModal()} should only be called once per page load. This ensures that's true.
     */
    static private bool $langModalRetrieved = false;
    /**
     * Gets whether {@link LangDriver::getLangModal()} has been called already using {@link LangDriver::$langModalRetrieved}.
     * @return bool
     */
    public static function langModalRetrieved(): bool
    {
        return self::$langModalRetrieved;
    }

    /**
     * Initialize language backend. Uses the URI to determine the page language.
     * <br> - Defaults to the browser's language.
     * <br> &nbsp;&nbsp;&nbsp;&nbsp;- Defaults to en-US if unsupported.
     * @return void
     */
    public static function langInit(): void
    {
        if (!self::$langInitCalled) {
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
                } else {
                    $finalLocale = $possibleLang->getLocale();
                    setcookie('locale', $finalLocale, [
                        'expires' => time() + 31536000, // 1 year
                        'path' => '/',
                        'httponly' => true,
                        'secure' => true, // if you're using https
                        'samesite' => 'Lax',
                    ]);
                }
            }
        }
    }

    /**
     * Gets the locale stored in cookies.
     * <br> - Defaults to the URI locale.
     * <br> &nbsp;&nbsp;&nbsp;&nbsp;- Defaults to en-US if unsupported.
     * <br> - Defaults to en-US if cookies aren't supported.
     * <br> - Reloads page if the url and cookie don't match (for bug fixes).
     * @return Lang
     */
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

    /**
     * Gets the html for the lang modal.
     * @return string
     */
    public static function getLangModal(): string
    {
        $activeLang = LangDriver::getStoredLang();

        if (!self::$langModalRetrieved) {
            $buttonTitle = new LangSet();
            $changeLangStr = new LangSet();
            try {
                $buttonTitle->set(Lang::BULGARIAN, "Език на сайта");
                $buttonTitle->set(Lang::CHINESE_CHINA, "网站语言");
                $buttonTitle->set(Lang::CHINESE_TAIWAN, "網站語言");
                $buttonTitle->set(Lang::CROATIAN, "Jezik web stranice");
                $buttonTitle->set(Lang::CZECH, "Jazyk webu");
                $buttonTitle->set(Lang::DANISH, "Sproget på siden");
                $buttonTitle->set(Lang::DUTCH, "Taal van de website");
                $buttonTitle->set(Lang::ENGLISH_UK, "Site Language");
                $buttonTitle->set(Lang::ENGLISH_US, "Site Language");
                $buttonTitle->set(Lang::FINNISH, "Sivuston kieli");
                $buttonTitle->set(Lang::FRENCH, "Langue du site");
                $buttonTitle->set(Lang::GERMAN, "Sprache der Webseite");
                $buttonTitle->set(Lang::GREEK, "Γλώσσα ιστότοπου");
                $buttonTitle->set(Lang::HINDI, "साइट की भाषा");
                $buttonTitle->set(Lang::HUNGARIAN, "Weboldal nyelve");
                $buttonTitle->set(Lang::INDONESIAN, "Bahasa Situs");
                $buttonTitle->set(Lang::ITALIAN, "Lingua del sito");
                $buttonTitle->set(Lang::JAPANESE, "サイトの言語");
                $buttonTitle->set(Lang::KOREAN, "사이트 언어");
                $buttonTitle->set(Lang::LITHUANIAN, "Svetainės kalba");
                $buttonTitle->set(Lang::NORWEGIAN, "Nettstedets språk");
                $buttonTitle->set(Lang::POLISH, "Język strony");
                $buttonTitle->set(Lang::PORTUGUESE_BRAZILIAN, "Idioma do site");
                $buttonTitle->set(Lang::ROMANIAN_ROMANIA, "Limba site-ului");
                $buttonTitle->set(Lang::RUSSIAN, "Язык сайта");
                $buttonTitle->set(Lang::SPANISH, "Idioma del sitio");
                $buttonTitle->set(Lang::SPANISH_LATAM, "Idioma del sitio");
                $buttonTitle->set(Lang::SWEDISH, "Webbplatsens språk");
                $buttonTitle->set(Lang::THAI, "ภาษาของเว็บไซต์");
                $buttonTitle->set(Lang::TURKISH, "Site Dili");
                $buttonTitle->set(Lang::UKRAINIAN, "Мова сайту");
                $buttonTitle->set(Lang::VIETNAMESE, "Ngôn ngữ của trang web");

                $changeLangStr->set(Lang::BULGARIAN, "Смяна на езика?");
                $changeLangStr->set(Lang::CHINESE_CHINA, "更改语言？");
                $changeLangStr->set(Lang::CHINESE_TAIWAN, "更改語言？");
                $changeLangStr->set(Lang::CROATIAN, "Promijeniti jezik?");
                $changeLangStr->set(Lang::CZECH, "Změnit jazyk?");
                $changeLangStr->set(Lang::DANISH, "Skift sprog?");
                $changeLangStr->set(Lang::DUTCH, "Taal wijzigen?");
                $changeLangStr->set(Lang::ENGLISH_UK, "Change Language?");
                $changeLangStr->set(Lang::ENGLISH_US, "Change Language?");
                $changeLangStr->set(Lang::FINNISH, "Vaihda kieltä?");
                $changeLangStr->set(Lang::FRENCH, "Changer de langue ?");
                $changeLangStr->set(Lang::GERMAN, "Sprache ändern?");
                $changeLangStr->set(Lang::GREEK, "Αλλαγή γλώσσας;");
                $changeLangStr->set(Lang::HINDI, "भाषा बदलें?");
                $changeLangStr->set(Lang::HUNGARIAN, "Nyelv megváltoztatása?");
                $changeLangStr->set(Lang::INDONESIAN, "Ubah bahasa?");
                $changeLangStr->set(Lang::ITALIAN, "Cambiare lingua?");
                $changeLangStr->set(Lang::JAPANESE, "言語を変更しますか？");
                $changeLangStr->set(Lang::KOREAN, "언어를 변경하시겠습니까?");
                $changeLangStr->set(Lang::LITHUANIAN, "Keisti kalbą?");
                $changeLangStr->set(Lang::NORWEGIAN, "Endre språk?");
                $changeLangStr->set(Lang::POLISH, "Zmień język?");
                $changeLangStr->set(Lang::PORTUGUESE_BRAZILIAN, "Mudar o idioma?");
                $changeLangStr->set(Lang::ROMANIAN_ROMANIA, "Schimbați limba?");
                $changeLangStr->set(Lang::RUSSIAN, "Сменить язык?");
                $changeLangStr->set(Lang::SPANISH, "¿Cambiar idioma?");
                $changeLangStr->set(Lang::SPANISH_LATAM, "¿Cambiar idioma?");
                $changeLangStr->set(Lang::SWEDISH, "Byta språk?");
                $changeLangStr->set(Lang::THAI, "เปลี่ยนภาษา?");
                $changeLangStr->set(Lang::TURKISH, "Dili değiştir?");
                $changeLangStr->set(Lang::UKRAINIAN, "Змінити мову?");
                $changeLangStr->set(Lang::VIETNAMESE, "Thay đổi ngôn ngữ?");
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
                <div class="lang_modal_heading_container">
                    <div class="lang_modal_heading_title"><?php echo $buttonTitle->get($activeLang)->getString(); ?></div>
                    <div class="lang_modal_heading_language"><?php echo $activeLang->getNativeName(); ?></div>
                    <div class="lang_modal_heading_change"><?php echo $changeLangStr->get($activeLang)->getString(); ?></div>
                </div>
                <div class="lang_modal_selector_container">
                    <?php
                    foreach (Lang::cases() as $l) {
                        if ($l != Lang::UNKNOWN) {
                            ?>
                            <a class="lang_modal_selector<?php echo $l === $activeLang ? " active" : ""; ?>" href="<?php echo preg_replace('/^\/(' . preg_quote(str_replace('-', '_', $activeLang->getLocale()), '/') . '|' . preg_quote(str_replace('_', '-', $activeLang->getLocale()), '/') . ')\b/', '/' . str_replace('-', '_', $l->getLocale()), $_SERVER['REQUEST_URI'], 1); ?>">

                                <!-- TODO: Maybe make the entire link background a low-opacity, slightly blurred image of the country's flag with/without the icon. -->
                                <div class="lang_modal_icon" style="background-image: url(<?php echo $l->getFlag()->getUrl(); ?>);"></div>
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
            self::$langModalRetrieved = true;
            return ob_get_clean();
        }
        return "";
    }
}