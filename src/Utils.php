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
    static private bool $phpInitCalled = false;
    static private bool $headInitCalled = false;
    static private bool $displayErrorsCalled = false;
    static private bool $langModalRetrieved = false;
    static private bool $showingConstruction = false;

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
        if (!self::$headInitCalled) {
            ob_start();
            ?>
            <link rel="stylesheet" href="/styles/global.css">
            <link rel="icon" href="/assets/chatbridge/icon.svg" type="image/svg">
            <?php
            self::$headInitCalled = true;
            return ob_get_clean();
        }
        return "";
    }

    public static function phpInit(): void
    {
        if (!self::$phpInitCalled) {
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
                        'expires' => time() + 31536000, // 1 year
                        'path' => '/',
                        'httponly' => true,
                        'secure' => true, // if you're using https
                        'samesite' => 'Lax',
                    ]);
                }
            }

            self::$phpInitCalled = true;
            Utils::displayErrors();
        }
    }

    public static function displayErrors(): void
    {
        if (!self::$displayErrorsCalled) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            self::$displayErrorsCalled = true;
        }
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

    public static function showConstruction(bool $enabled = true): void
    {
        if (!self::$showingConstruction) {
            if ($enabled && !isset($_GET['force']) && $_GET['force'] != 'true') {
                Utils::phpInit();
                $activeLang = Utils::getStoredLang();

                $title = new LangSet();
                $contentTitle = new LangSet();
                $content = new LangSet();
                try {
                    $title->set(Lang::BULGARIAN, "ChatBridge - В процес на изграждане");
                    $title->set(Lang::CHINESE_CHINA, "ChatBridge - 正在建设中");
                    $title->set(Lang::CHINESE_TAIWAN, "ChatBridge - 建設中");
                    $title->set(Lang::CROATIAN, "ChatBridge - U izradi");
                    $title->set(Lang::CZECH, "ChatBridge - Ve výstavbě");
                    $title->set(Lang::DANISH, "ChatBridge - Under opbygning");
                    $title->set(Lang::DUTCH, "ChatBridge - In aanbouw");
                    $title->set(Lang::ENGLISH_UK, "ChatBridge - Under Construction");
                    $title->set(Lang::ENGLISH_US, "ChatBridge - Under Construction");
                    $title->set(Lang::FINNISH, "ChatBridge - Rakenteilla");
                    $title->set(Lang::FRENCH, "ChatBridge - En construction");
                    $title->set(Lang::GERMAN, "ChatBridge - Im Aufbau");
                    $title->set(Lang::GREEK, "ChatBridge - Υπό κατασκευή");
                    $title->set(Lang::HINDI, "ChatBridge - निर्माणाधीन");
                    $title->set(Lang::HUNGARIAN, "ChatBridge - Építés alatt");
                    $title->set(Lang::INDONESIAN, "ChatBridge - Sedang dalam pembangunan");
                    $title->set(Lang::ITALIAN, "ChatBridge - In costruzione");
                    $title->set(Lang::JAPANESE, "ChatBridge - 工事中");
                    $title->set(Lang::KOREAN, "ChatBridge - 공사 중");
                    $title->set(Lang::LITHUANIAN, "ChatBridge - Kuriama");
                    $title->set(Lang::NORWEGIAN, "ChatBridge - Under konstruksjon");
                    $title->set(Lang::POLISH, "ChatBridge - W budowie");
                    $title->set(Lang::PORTUGUESE_BRAZILIAN, "ChatBridge - Em construção");
                    $title->set(Lang::ROMANIAN_ROMANIA, "ChatBridge - În construcție");
                    $title->set(Lang::RUSSIAN, "ChatBridge - В разработке");
                    $title->set(Lang::SPANISH, "ChatBridge - En construcción");
                    $title->set(Lang::SPANISH_LATAM, "ChatBridge - En construcción");
                    $title->set(Lang::SWEDISH, "ChatBridge - Under konstruktion");
                    $title->set(Lang::THAI, "ChatBridge - กำลังก่อสร้าง");
                    $title->set(Lang::TURKISH, "ChatBridge - Yapım aşamasında");
                    $title->set(Lang::UKRAINIAN, "ChatBridge - У процесі розробки");
                    $title->set(Lang::VIETNAMESE, "ChatBridge - Đang xây dựng");

                    $contentTitle->set(Lang::BULGARIAN, "В процес на изграждане");
                    $contentTitle->set(Lang::CHINESE_CHINA, "正在建设中");
                    $contentTitle->set(Lang::CHINESE_TAIWAN, "建設中");
                    $contentTitle->set(Lang::CROATIAN, "U izradi");
                    $contentTitle->set(Lang::CZECH, "Ve výstavbě");
                    $contentTitle->set(Lang::DANISH, "Under opbygning");
                    $contentTitle->set(Lang::DUTCH, "In aanbouw");
                    $contentTitle->set(Lang::ENGLISH_UK, "Under Construction");
                    $contentTitle->set(Lang::ENGLISH_US, "Under Construction");
                    $contentTitle->set(Lang::FINNISH, "Rakenteilla");
                    $contentTitle->set(Lang::FRENCH, "En construction");
                    $contentTitle->set(Lang::GERMAN, "Im Aufbau");
                    $contentTitle->set(Lang::GREEK, "Υπό κατασκευή");
                    $contentTitle->set(Lang::HINDI, "निर्माणाधीन");
                    $contentTitle->set(Lang::HUNGARIAN, "Építés alatt");
                    $contentTitle->set(Lang::INDONESIAN, "Sedang dalam pembangunan");
                    $contentTitle->set(Lang::ITALIAN, "In costruzione");
                    $contentTitle->set(Lang::JAPANESE, "工事中");
                    $contentTitle->set(Lang::KOREAN, "공사 중");
                    $contentTitle->set(Lang::LITHUANIAN, "Kuriama");
                    $contentTitle->set(Lang::NORWEGIAN, "Under konstruksjon");
                    $contentTitle->set(Lang::POLISH, "W budowie");
                    $contentTitle->set(Lang::PORTUGUESE_BRAZILIAN, "Em construção");
                    $contentTitle->set(Lang::ROMANIAN_ROMANIA, "În construcție");
                    $contentTitle->set(Lang::RUSSIAN, "В разработке");
                    $contentTitle->set(Lang::SPANISH, "En construcción");
                    $contentTitle->set(Lang::SPANISH_LATAM, "En construcción");
                    $contentTitle->set(Lang::SWEDISH, "Under konstruktion");
                    $contentTitle->set(Lang::THAI, "กำลังก่อสร้าง");
                    $contentTitle->set(Lang::TURKISH, "Yapım aşamasında");
                    $contentTitle->set(Lang::UKRAINIAN, "У процесі розробки");
                    $contentTitle->set(Lang::VIETNAMESE, "Đang xây dựng");

                    $content->set(Lang::BULGARIAN, "В момента работим върху тази страница.<br>Моля, проверете по-късно.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Присъединете се към нашия Discord сървър за актуализации!</a>");
                    $content->set(Lang::CHINESE_CHINA, "我们正在努力建设此页面。<br>请稍后再回来查看。<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">加入我们的 Discord 服务器获取最新消息！</a>");
                    $content->set(Lang::CHINESE_TAIWAN, "我們正在努力建設此頁面。<br>請稍後再回來查看。<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">加入我們的 Discord 伺服器以獲取最新消息！</a>");
                    $content->set(Lang::CROATIAN, "Trenutno radimo na ovoj stranici.<br>Molimo provjerite kasnije.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Pridružite se našem Discord serveru za novosti!</a>");
                    $content->set(Lang::CZECH, "Na této stránce právě pracujeme.<br>Zkontrolujte ji prosím později.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Připojte se k našemu Discord serveru pro novinky!</a>");
                    $content->set(Lang::DANISH, "Vi arbejder i øjeblikket på denne side.<br>Kom venligst tilbage senere.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Slut dig til vores Discord-server for opdateringer!</a>");
                    $content->set(Lang::DUTCH, "We werken momenteel aan deze pagina.<br>Kom later nog eens terug.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Word lid van onze Discord-server voor updates!</a>");
                    $content->set(Lang::ENGLISH_UK, "We are currently working on this page.<br>Please check back later.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Join our Discord server for updates!</a>");
                    $content->set(Lang::ENGLISH_US, "We are currently working on this page.<br>Please check back later.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Join our Discord server for updates!</a>");
                    $content->set(Lang::FINNISH, "Työskentelemme parhaillaan tällä sivulla.<br>Tarkista myöhemmin uudelleen.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Liity Discord-palvelimellemme saadaksesi päivityksiä!</a>");
                    $content->set(Lang::FRENCH, "Nous travaillons actuellement sur cette page.<br>Veuillez revenir plus tard.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Rejoignez notre serveur Discord pour des mises à jour !</a>");
                    $content->set(Lang::GERMAN, "Wir arbeiten derzeit an dieser Seite.<br>Bitte schauen Sie später noch einmal vorbei.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Treten Sie unserem Discord-Server für Updates bei!</a>");
                    $content->set(Lang::GREEK, "Αυτή τη στιγμή εργαζόμαστε σε αυτήν τη σελίδα.<br>Παρακαλούμε ελέγξτε ξανά αργότερα.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Εγγραφείτε στο Discord server μας για ενημερώσεις!</a>");
                    $content->set(Lang::HINDI, "हम वर्तमान में इस पृष्ठ पर काम कर रहे हैं।<br>कृपया बाद में फिर से जांचें।<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">अपडेट्स के लिए हमारे Discord सर्वर से जुड़ें!");
                    $content->set(Lang::HUNGARIAN, "Jelenleg dolgozunk ezen az oldalon.<br>Kérjük, nézzen vissza később.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Csatlakozzon Discord szerverünkhöz a frissítésekért!</a>");
                    $content->set(Lang::INDONESIAN, "Kami sedang mengerjakan halaman ini.<br>Silakan kembali lagi nanti.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Bergabunglah dengan server Discord kami untuk pembaruan!</a>");
                    $content->set(Lang::ITALIAN, "Stiamo attualmente lavorando su questa pagina.<br>Controlla di nuovo più tardi.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Unisciti al nostro server Discord per aggiornamenti!</a>");
                    $content->set(Lang::JAPANESE, "現在、このページの作業を進めています。<br>後ほど再度ご確認ください。<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">最新情報はDiscordサーバーに参加してください！</a>");
                    $content->set(Lang::KOREAN, "현재 이 페이지를 작업 중입니다.<br>나중에 다시 확인해 주세요.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">업데이트를 위해 Discord 서버에 참여하세요!</a>");
                    $content->set(Lang::LITHUANIAN, "Šiuo metu dirbame su šiuo puslapiu.<br>Patikrinkite vėliau.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Prisijunkite prie mūsų Discord serverio dėl atnaujinimų!</a>");
                    $content->set(Lang::NORWEGIAN, "Vi jobber for øyeblikket med denne siden.<br>Vennligst sjekk tilbake senere.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Bli med på vår Discord-server for oppdateringer!</a>");
                    $content->set(Lang::POLISH, "Obecnie pracujemy nad tą stroną.<br>Proszę sprawdzić ponownie później.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Dołącz do naszego serwera Discord, aby otrzymywać aktualizacje!</a>");
                    $content->set(Lang::PORTUGUESE_BRAZILIAN, "Estamos trabalhando nesta página no momento.<br>Por favor, volte mais tarde.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Junte-se ao nosso servidor no Discord para atualizações!</a>");
                    $content->set(Lang::ROMANIAN_ROMANIA, "În prezent lucrăm la această pagină.<br>Vă rugăm să reveniți mai târziu.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Alăturați-vă serverului nostru Discord pentru actualizări!</a>");
                    $content->set(Lang::RUSSIAN, "Мы в настоящее время работаем над этой страницей.<br>Пожалуйста, зайдите позже.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Присоединяйтесь к нашему Discord серверу для обновлений!</a>");
                    $content->set(Lang::SPANISH, "Actualmente estamos trabajando en esta página.<br>Por favor, vuelva más tarde.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">¡Únete a nuestro servidor de Discord para actualizaciones!</a>");
                    $content->set(Lang::SPANISH_LATAM, "Actualmente estamos trabajando en esta página.<br>Por favor, vuelva más tarde.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">¡Únete a nuestro servidor de Discord para actualizaciones!</a>");
                    $content->set(Lang::SWEDISH, "Vi arbetar för närvarande med denna sida.<br>Vänligen kom tillbaka senare.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Gå med i vår Discord-server för uppdateringar!</a>");
                    $content->set(Lang::THAI, "เรากำลังทำงานในหน้านี้อยู่ในขณะนี้<br>กรุณากลับมาตรวจสอบอีกครั้งภายหลัง<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">เข้าร่วมเซิร์ฟเวอร์ Discord ของเราสำหรับการอัปเดต!</a>");
                    $content->set(Lang::TURKISH, "Şu anda bu sayfa üzerinde çalışıyoruz.<br>Lütfen daha sonra tekrar kontrol edin.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Güncellemeler için Discord sunucumuza katılın!</a>");
                    $content->set(Lang::UKRAINIAN, "Ми зараз працюємо над цією сторінкою.<br>Будь ласка, поверніться пізніше.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Приєднуйтесь до нашого Discord-сервера для оновлень!</a>");
                    $content->set(Lang::VIETNAMESE, "Chúng tôi hiện đang làm việc trên trang này.<br>Vui lòng quay lại sau.<br><br><a class=\"link\" href=\"https://discord.gg/cXyznWjfJv\">Tham gia máy chủ Discord của chúng tôi để nhận cập nhật!</a>");
                } catch (LanguageException $e) {
                    die($e->getMessage());
                }

                ?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport"
                          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <?php echo Utils::headInit(); ?>
                    <link rel="stylesheet" href="/styles/construction.css">
                    <title><?php echo $title->get($activeLang)->getString(); ?></title>
                </head>
                <body>
                    <?php echo Utils::getLangModal($activeLang); ?>
                    <div class="construction_body_container">
                        <div class="construction_body">
                            <div class="construction_border top"></div>
                            <div class="construction_logo"><?php echo SVG::CHATBRIDGE_LOGO->get(null, "100%") ?></div>
                            <div class="construction_title"><?php echo $contentTitle->get($activeLang)->getString(); ?></div>
                            <div class="construction_content">
                                <?php echo $content->get($activeLang)->getString(); ?>
                            </div>
                            <div class="construction_border bottom"></div>
                        </div>
                    </div>
                </body>
                </html>
                <?php

                self::$showingConstruction = true;
                exit;
            }
        }
    }

    public static function getLangModal(Lang $activeLang): string
    {
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
            self::$langModalRetrieved = true;
        return ob_get_clean();
        }
        return "";
    }
}