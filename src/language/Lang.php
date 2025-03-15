<?php
namespace Ethanrobins\Chatbridge\Language;

/**
 * Enum Lang
 *
 * Represents various language and locale options with utility methods
 * for retrieving locale, language names, and region codes based on ISO standards.
 */
enum Lang
{
    case BULGARIAN;
    case CHINESE_CHINA;
    case CHINESE_TAIWAN;
    case CROATIAN;
    case CZECH;
    case DANISH;
    case DUTCH;
    case ENGLISH_UK;
    case ENGLISH_US;
    case FINNISH;
    case FRENCH;
    case GERMAN;
    case GREEK;
    case HINDI;
    case HUNGARIAN;
    case INDONESIAN;
    case ITALIAN;
    case JAPANESE;
    case KOREAN;
    case LITHUANIAN;
    case NORWEGIAN;
    case POLISH;
    case PORTUGUESE_BRAZILIAN;
    case ROMANIAN_ROMANIA;
    case RUSSIAN;
    case SPANISH;
    case SPANISH_LATAM;
    case SWEDISH;
    case THAI;
    case TURKISH;
    case UKRAINIAN;
    case VIETNAMESE;

    case UNKNOWN;

    /**
     * @return string The Discord-compatible locale value
     */
    public function getDiscordLocale(): string
    {
        return match ($this) {
            self::BULGARIAN => "bg",
            self::CHINESE_CHINA => "zh-CN",
            self::CHINESE_TAIWAN => "zh-TW",
            self::CROATIAN => "hr",
            self::CZECH => "cs",
            self::DANISH => "da",
            self::DUTCH => "nl",
            self::ENGLISH_UK => "en-GB",
            self::ENGLISH_US => "en-US",
            self::FINNISH => "fi",
            self::FRENCH => "fr",
            self::GERMAN => "de",
            self::GREEK => "el",
            self::HINDI => "hi",
            self::HUNGARIAN => "hu",
            self::INDONESIAN => "id",
            self::ITALIAN => "it",
            self::JAPANESE => "ja",
            self::KOREAN => "ko",
            self::LITHUANIAN => "lt",
            self::NORWEGIAN => "no",
            self::POLISH => "pl",
            self::PORTUGUESE_BRAZILIAN => "pt-BR",
            self::ROMANIAN_ROMANIA => "ro",
            self::RUSSIAN => "ru",
            self::SPANISH => "es-ES",
            self::SPANISH_LATAM => "es-419",
            self::SWEDISH => "sv",
            self::THAI => "th",
            self::TURKISH => "tr",
            self::UKRAINIAN => "uk",
            self::VIETNAMESE => "vi",
            self::UNKNOWN => "unknown",
            default => self::ENGLISH_US->getDiscordLocale()
        };
    }

    /**
     * @return string The `ISO 3166-1` Locale
     */
    public function getLocale(): string
    {
        return match ($this) {
            self::BULGARIAN => "bg",
            self::CHINESE_CHINA => "zh-CN",
            self::CHINESE_TAIWAN => "zh-TW",
            self::CROATIAN => "hr",
            self::CZECH => "cs",
            self::DANISH => "da",
            self::DUTCH => "nl",
            self::ENGLISH_UK => "en-GB",
            self::ENGLISH_US => "en-US",
            self::FINNISH => "fi",
            self::FRENCH => "fr",
            self::GERMAN => "de",
            self::GREEK => "el",
            self::HINDI => "hi",
            self::HUNGARIAN => "hu",
            self::INDONESIAN => "id",
            self::ITALIAN => "it",
            self::JAPANESE => "ja",
            self::KOREAN => "ko",
            self::LITHUANIAN => "lt",
            self::NORWEGIAN => "nb",
            self::POLISH => "pl",
            self::PORTUGUESE_BRAZILIAN => "pt-BR",
            self::ROMANIAN_ROMANIA => "ro",
            self::RUSSIAN => "ru",
            self::SPANISH => "es-ES",
            self::SPANISH_LATAM => "es-419",
            self::SWEDISH => "sv",
            self::THAI => "th",
            self::TURKISH => "tr",
            self::UKRAINIAN => "uk",
            self::VIETNAMESE => "vi",
            default => self::ENGLISH_US->getLocale()
        };
    }

    /**
     * @return string The `ISO 3166-1` language code
     */
    public function getLanguageCode(): string
    {
        return substr($this->getLocale(), 0, 2);
    }

    /**
     * @return string|null The `ISO 3166-1` region code, if applicable
     */
    public function getRegionCode(): ?string
    {
        $locale = $this->getLocale();
        return substr($locale, '-') ? explode('-', $locale)[1] : null;
    }

    /**
     * @return string The language name (in english)
     */
    public function getLanguageName(): string
    {
        return match ($this) {
            self::BULGARIAN => "Bulgarian",
            self::CHINESE_CHINA => "Chinese, China",
            self::CHINESE_TAIWAN => "Chinese, Taiwan",
            self::CROATIAN => "Croatian",
            self::CZECH => "Czech",
            self::DANISH => "Danish",
            self::DUTCH => "Dutch",
            self::ENGLISH_UK => "English, UK",
            self::ENGLISH_US => "English, US",
            self::FINNISH => "Finnish",
            self::FRENCH => "French",
            self::GERMAN => "German",
            self::GREEK => "Greek",
            self::HINDI => "Hindi",
            self::HUNGARIAN => "Hungarian",
            self::INDONESIAN => "Indonesian",
            self::ITALIAN => "Italian",
            self::JAPANESE => "Japanese",
            self::KOREAN => "Korean",
            self::LITHUANIAN => "Lithuanian",
            self::NORWEGIAN => "Norwegian",
            self::POLISH => "Polish",
            self::PORTUGUESE_BRAZILIAN => "Portuguese, Brazilian",
            self::ROMANIAN_ROMANIA => "Romanian, Romania",
            self::RUSSIAN => "Russian",
            self::SPANISH => "Spanish",
            self::SPANISH_LATAM => "Spanish, LATAM",
            self::SWEDISH => "Swedish",
            self::THAI => "Thai",
            self::TURKISH => "Turkish",
            self::UKRAINIAN => "Ukrainian",
            self::VIETNAMESE => "Vietnamese",
            self::UNKNOWN => "Unknown",
            default => self::ENGLISH_US->getLanguageName()
        };
    }
    public function getLanguageNameInLanguage(Lang $lang): string
    {
        switch ($lang) {
            case self::BULGARIAN:
                return match ($this) {
                    self::BULGARIAN            => self::BULGARIAN->getNativeName(),
                    self::CHINESE_CHINA        => "китайски (Китай)",
                    self::CHINESE_TAIWAN       => "китайски (Тайван)",
                    self::CROATIAN             => "хърватски",
                    self::CZECH                => "чешки",
                    self::DANISH               => "датски",
                    self::DUTCH                => "нидерландски",
                    self::ENGLISH_UK           => "английски (Обединено кралство)",
                    self::ENGLISH_US           => "английски (САЩ)",
                    self::FINNISH              => "фински",
                    self::FRENCH               => "френски",
                    self::GERMAN               => "немски",
                    self::GREEK                => "гръцки",
                    self::HINDI                => "хинди",
                    self::HUNGARIAN            => "унгарски",
                    self::INDONESIAN           => "индонезийски",
                    self::ITALIAN              => "италиански",
                    self::JAPANESE             => "японски",
                    self::KOREAN               => "корейски",
                    self::LITHUANIAN           => "литовски",
                    self::NORWEGIAN            => "норвежки",
                    self::POLISH               => "полски",
                    self::PORTUGUESE_BRAZILIAN => "португалски (Бразилия)",
                    self::ROMANIAN_ROMANIA     => "руменски",
                    self::RUSSIAN              => "руски",
                    self::SPANISH              => "испански",
                    self::SPANISH_LATAM        => "испански (Латинска Америка)",
                    self::SWEDISH              => "шведски",
                    self::THAI                 => "тайски",
                    self::TURKISH              => "турски",
                    self::UKRAINIAN            => "украински",
                    self::VIETNAMESE           => "виетнамски",
                    default                    => self::BULGARIAN->getLanguageName()
                };
            case self::CHINESE_CHINA:
                return match ($this) {
                    self::BULGARIAN            => "保加利亚语",
                    self::CHINESE_CHINA        => self::CHINESE_CHINA->getNativeName(),
                    self::CHINESE_TAIWAN       => "繁体中文（台湾）",
                    self::CROATIAN             => "克罗地亚语",
                    self::CZECH                => "捷克语",
                    self::DANISH               => "丹麦语",
                    self::DUTCH                => "荷兰语",
                    self::ENGLISH_UK           => "英语（英国）",
                    self::ENGLISH_US           => "英语（美国）",
                    self::FINNISH              => "芬兰语",
                    self::FRENCH               => "法语",
                    self::GERMAN               => "德语",
                    self::GREEK                => "希腊语",
                    self::HINDI                => "印地语",
                    self::HUNGARIAN            => "匈牙利语",
                    self::INDONESIAN           => "印尼语",
                    self::ITALIAN              => "意大利语",
                    self::JAPANESE             => "日语",
                    self::KOREAN               => "韩语",
                    self::LITHUANIAN           => "立陶宛语",
                    self::NORWEGIAN            => "挪威语",
                    self::POLISH               => "波兰语",
                    self::PORTUGUESE_BRAZILIAN => "葡萄牙语（巴西）",
                    self::ROMANIAN_ROMANIA     => "罗马尼亚语",
                    self::RUSSIAN              => "俄语",
                    self::SPANISH              => "西班牙语",
                    self::SPANISH_LATAM        => "西班牙语（拉丁美洲）",
                    self::SWEDISH              => "瑞典语",
                    self::THAI                 => "泰语",
                    self::TURKISH              => "土耳其语",
                    self::UKRAINIAN            => "乌克兰语",
                    self::VIETNAMESE           => "越南语",
                    default                    => self::CHINESE_CHINA->getLanguageName()
                };
            case self::CHINESE_TAIWAN:
                return match ($this) {
                    self::BULGARIAN            => "保加利亞語",
                    self::CHINESE_CHINA        => "中文（中國大陸）",
                    self::CHINESE_TAIWAN       => self::CHINESE_TAIWAN->getNativeName(),
                    self::CROATIAN             => "克羅埃西亞語",
                    self::CZECH                => "捷克語",
                    self::DANISH               => "丹麥語",
                    self::DUTCH                => "荷蘭語",
                    self::ENGLISH_UK           => "英語（英國）",
                    self::ENGLISH_US           => "英語（美國）",
                    self::FINNISH              => "芬蘭語",
                    self::FRENCH               => "法語",
                    self::GERMAN               => "德語",
                    self::GREEK                => "希臘語",
                    self::HINDI                => "印地語",
                    self::HUNGARIAN            => "匈牙利語",
                    self::INDONESIAN           => "印尼語",
                    self::ITALIAN              => "義大利語",
                    self::JAPANESE             => "日語",
                    self::KOREAN               => "韓語",
                    self::LITHUANIAN           => "立陶宛語",
                    self::NORWEGIAN            => "挪威語",
                    self::POLISH               => "波蘭語",
                    self::PORTUGUESE_BRAZILIAN => "葡萄牙語（巴西）",
                    self::ROMANIAN_ROMANIA     => "羅馬尼亞語",
                    self::RUSSIAN              => "俄語",
                    self::SPANISH              => "西班牙語",
                    self::SPANISH_LATAM        => "西班牙語（拉丁美洲）",
                    self::SWEDISH              => "瑞典語",
                    self::THAI                 => "泰語",
                    self::TURKISH              => "土耳其語",
                    self::UKRAINIAN            => "烏克蘭語",
                    self::VIETNAMESE           => "越南語",
                    default                    => self::CHINESE_TAIWAN->getLanguageName()
                };
            case self::CROATIAN:
                return match ($this) {
                    self::BULGARIAN            => "Bugarski",
                    self::CHINESE_CHINA        => "Kineski (Kina)",
                    self::CHINESE_TAIWAN       => "Kineski (Tajvan)",
                    self::CROATIAN             => self::CROATIAN->getNativeName(),
                    self::CZECH                => "Češki",
                    self::DANISH               => "Danski",
                    self::DUTCH                => "Nizozemski",
                    self::ENGLISH_UK           => "Engleski (UK)",
                    self::ENGLISH_US           => "Engleski (SAD)",
                    self::FINNISH              => "Finski",
                    self::FRENCH               => "Francuski",
                    self::GERMAN               => "Njemački",
                    self::GREEK                => "Grčki",
                    self::HINDI                => "Hindu",
                    self::HUNGARIAN            => "Mađarski",
                    self::INDONESIAN           => "Indonezijski",
                    self::ITALIAN              => "Talijanski",
                    self::JAPANESE             => "Japanski",
                    self::KOREAN               => "Korejski",
                    self::LITHUANIAN           => "Litvanski",
                    self::NORWEGIAN            => "Norveški",
                    self::POLISH               => "Poljski",
                    self::PORTUGUESE_BRAZILIAN => "Portugalski (Brazilski)",
                    self::ROMANIAN_ROMANIA     => "Rumunjski",
                    self::RUSSIAN              => "Ruski",
                    self::SPANISH              => "Španjolski",
                    self::SPANISH_LATAM        => "Španjolski (Latinska Amerika)",
                    self::SWEDISH              => "Švedski",
                    self::THAI                 => "Tajlandski",
                    self::TURKISH              => "Turski",
                    self::UKRAINIAN            => "Ukrajinski",
                    self::VIETNAMESE           => "Vijetnamski",
                    default                    => self::CROATIAN->getLanguageName()
                };
            case self::CZECH:
                return match ($this) {
                    self::BULGARIAN            => "bulharština",
                    self::CHINESE_CHINA        => "čínština (Čína)",
                    self::CHINESE_TAIWAN       => "čínština (Tchaj-wan)",
                    self::CROATIAN             => "chorvatština",
                    self::CZECH                => self::CZECH->getNativeName(),
                    self::DANISH               => "dánština",
                    self::DUTCH                => "nizozemština",
                    self::ENGLISH_UK           => "angličtina (UK)",
                    self::ENGLISH_US           => "angličtina (USA)",
                    self::FINNISH              => "finština",
                    self::FRENCH               => "francouzština",
                    self::GERMAN               => "němčina",
                    self::GREEK                => "řečtina",
                    self::HINDI                => "hindština",
                    self::HUNGARIAN            => "maďarština",
                    self::INDONESIAN           => "indonézština",
                    self::ITALIAN              => "italština",
                    self::JAPANESE             => "japonština",
                    self::KOREAN               => "korejština",
                    self::LITHUANIAN           => "litevština",
                    self::NORWEGIAN            => "norština",
                    self::POLISH               => "polština",
                    self::PORTUGUESE_BRAZILIAN => "portugalština (Brazílie)",
                    self::ROMANIAN_ROMANIA     => "rumunština",
                    self::RUSSIAN              => "ruština",
                    self::SPANISH              => "španělština",
                    self::SPANISH_LATAM        => "španělština (Latinská Amerika)",
                    self::SWEDISH              => "švédština",
                    self::THAI                 => "thajština",
                    self::TURKISH              => "turečtina",
                    self::UKRAINIAN            => "ukrajinština",
                    self::VIETNAMESE           => "vietnamština",
                    default                    => self::CZECH->getLanguageName()
                };
            case self::DANISH:
                return match ($this) {
                    self::BULGARIAN            => "bulgarsk",
                    self::CHINESE_CHINA        => "kinesisk (Kina)",
                    self::CHINESE_TAIWAN       => "kinesisk (Taiwan)",
                    self::CROATIAN             => "kroatisk",
                    self::CZECH                => "tjekkisk",
                    self::DANISH               => self::DANISH->getNativeName(),
                    self::DUTCH                => "hollandsk",
                    self::ENGLISH_UK           => "engelsk (UK)",
                    self::ENGLISH_US           => "engelsk (USA)",
                    self::FINNISH              => "finsk",
                    self::FRENCH               => "fransk",
                    self::GERMAN               => "tysk",
                    self::GREEK                => "græsk",
                    self::HINDI                => "hindi",
                    self::HUNGARIAN            => "ungarsk",
                    self::INDONESIAN           => "indonesisk",
                    self::ITALIAN              => "italiensk",
                    self::JAPANESE             => "japansk",
                    self::KOREAN               => "koreansk",
                    self::LITHUANIAN           => "litauisk",
                    self::NORWEGIAN            => "norsk",
                    self::POLISH               => "polsk",
                    self::PORTUGUESE_BRAZILIAN => "portugisisk (Brasilien)",
                    self::ROMANIAN_ROMANIA     => "rumænsk",
                    self::RUSSIAN              => "russisk",
                    self::SPANISH              => "spansk",
                    self::SPANISH_LATAM        => "spansk (Latinamerika)",
                    self::SWEDISH              => "svensk",
                    self::THAI                 => "thailandsk",
                    self::TURKISH              => "tyrkisk",
                    self::UKRAINIAN            => "ukrainsk",
                    self::VIETNAMESE           => "vietnamesisk",
                    default                    => self::DANISH->getLanguageName()
                };
            case self::DUTCH:
                return match ($this) {
                    self::BULGARIAN            => "Bulgaars",
                    self::CHINESE_CHINA        => "Chinees (China)",
                    self::CHINESE_TAIWAN       => "Chinees (Taiwan)",
                    self::CROATIAN             => "Kroatisch",
                    self::CZECH                => "Tsjechisch",
                    self::DANISH               => "Deens",
                    self::DUTCH                => self::DUTCH->getNativeName(),
                    self::ENGLISH_UK           => "Engels (VK)",
                    self::ENGLISH_US           => "Engels (VS)",
                    self::FINNISH              => "Fins",
                    self::FRENCH               => "Frans",
                    self::GERMAN               => "Duits",
                    self::GREEK                => "Grieks",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Hongaars",
                    self::INDONESIAN           => "Indonesisch",
                    self::ITALIAN              => "Italiaans",
                    self::JAPANESE             => "Japans",
                    self::KOREAN               => "Koreaans",
                    self::LITHUANIAN           => "Litouws",
                    self::NORWEGIAN            => "Noors",
                    self::POLISH               => "Pools",
                    self::PORTUGUESE_BRAZILIAN => "Portugees (Brazilië)",
                    self::ROMANIAN_ROMANIA     => "Roemeens",
                    self::RUSSIAN              => "Russisch",
                    self::SPANISH              => "Spaans",
                    self::SPANISH_LATAM        => "Spaans (Latijns-Amerika)",
                    self::SWEDISH              => "Zweeds",
                    self::THAI                 => "Thais",
                    self::TURKISH              => "Turks",
                    self::UKRAINIAN            => "Oekraïens",
                    self::VIETNAMESE           => "Vietnamees",
                    default                    => self::DUTCH->getLanguageName()
                };
            case self::FINNISH:
                return match ($this) {
                    self::BULGARIAN            => "Bulgaria",
                    self::CHINESE_CHINA        => "Kiina (Mandariini)",
                    self::CHINESE_TAIWAN       => "Kiina (Perinteinen)",
                    self::CROATIAN             => "Kroaatti",
                    self::CZECH                => "Tšekki",
                    self::DANISH               => "Tanska",
                    self::DUTCH                => "Hollanti",
                    self::ENGLISH_UK           => "Englanti (UK)",
                    self::ENGLISH_US           => "Englanti (US)",
                    self::FINNISH              => self::FINNISH->getNativeName(),
                    self::FRENCH               => "Ranska",
                    self::GERMAN               => "Saksa",
                    self::GREEK                => "Kreikka",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Unkari",
                    self::INDONESIAN           => "Indonesia",
                    self::ITALIAN              => "Italia",
                    self::JAPANESE             => "Japani",
                    self::KOREAN               => "Korea",
                    self::LITHUANIAN           => "Liettua",
                    self::NORWEGIAN            => "Norja",
                    self::POLISH               => "Puola",
                    self::PORTUGUESE_BRAZILIAN => "Portugali (Brasilia)",
                    self::ROMANIAN_ROMANIA     => "Romania",
                    self::RUSSIAN              => "Venäjä",
                    self::SPANISH              => "Espanja",
                    self::SPANISH_LATAM        => "Espanja (Latinalainen Amerikka)",
                    self::SWEDISH              => "Ruotsi",
                    self::THAI                 => "Thai",
                    self::TURKISH              => "Turkki",
                    self::UKRAINIAN            => "Ukraina",
                    self::VIETNAMESE           => "Vietnam",
                    default                    => self::FINNISH->getLanguageName()
                };
            case self::FRENCH:
                return match ($this) {
                    self::BULGARIAN            => "Bulgare",
                    self::CHINESE_CHINA        => "Chinois (Chine)",
                    self::CHINESE_TAIWAN       => "Chinois (Taïwan)",
                    self::CROATIAN             => "Croate",
                    self::CZECH                => "Tchèque",
                    self::DANISH               => "Danois",
                    self::DUTCH                => "Néerlandais",
                    self::ENGLISH_UK           => "Anglais (Royaume-Uni)",
                    self::ENGLISH_US           => "Anglais (États-Unis)",
                    self::FINNISH              => "Finnois",
                    self::FRENCH               => self::FRENCH->getNativeName(),
                    self::GERMAN               => "Allemand",
                    self::GREEK                => "Grec",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Hongrois",
                    self::INDONESIAN           => "Indonésien",
                    self::ITALIAN              => "Italien",
                    self::JAPANESE             => "Japonais",
                    self::KOREAN               => "Coréen",
                    self::LITHUANIAN           => "Lituanien",
                    self::NORWEGIAN            => "Norvégien",
                    self::POLISH               => "Polonais",
                    self::PORTUGUESE_BRAZILIAN => "Portugais (Brésil)",
                    self::ROMANIAN_ROMANIA     => "Roumain",
                    self::RUSSIAN              => "Russe",
                    self::SPANISH              => "Espagnol",
                    self::SPANISH_LATAM        => "Espagnol (Amérique latine)",
                    self::SWEDISH              => "Suédois",
                    self::THAI                 => "Thaï",
                    self::TURKISH              => "Turc",
                    self::UKRAINIAN            => "Ukrainien",
                    self::VIETNAMESE           => "Vietnamien",
                    default                    => self::FRENCH->getLanguageName()
                };
            case self::GERMAN:
                return match ($this) {
                    self::BULGARIAN            => "Bulgarisch",
                    self::CHINESE_CHINA        => "Chinesisch (China)",
                    self::CHINESE_TAIWAN       => "Chinesisch (Taiwan)",
                    self::CROATIAN             => "Kroatisch",
                    self::CZECH                => "Tschechisch",
                    self::DANISH               => "Dänisch",
                    self::DUTCH                => "Niederländisch",
                    self::ENGLISH_UK           => "Englisch (UK)",
                    self::ENGLISH_US           => "Englisch (USA)",
                    self::FINNISH              => "Finnisch",
                    self::FRENCH               => "Französisch",
                    self::GERMAN               => self::GERMAN->getNativeName(),
                    self::GREEK                => "Griechisch",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Ungarisch",
                    self::INDONESIAN           => "Indonesisch",
                    self::ITALIAN              => "Italienisch",
                    self::JAPANESE             => "Japanisch",
                    self::KOREAN               => "Koreanisch",
                    self::LITHUANIAN           => "Litauisch",
                    self::NORWEGIAN            => "Norwegisch",
                    self::POLISH               => "Polnisch",
                    self::PORTUGUESE_BRAZILIAN => "Portugiesisch (Brasilien)",
                    self::ROMANIAN_ROMANIA     => "Rumänisch",
                    self::RUSSIAN              => "Russisch",
                    self::SPANISH              => "Spanisch",
                    self::SPANISH_LATAM        => "Spanisch (Lateinamerika)",
                    self::SWEDISH              => "Schwedisch",
                    self::THAI                 => "Thailändisch",
                    self::TURKISH              => "Türkisch",
                    self::UKRAINIAN            => "Ukrainisch",
                    self::VIETNAMESE           => "Vietnamesisch",
                    default                    => self::GERMAN->getLanguageName()
                };
            case self::GREEK:
                return match ($this) {
                    self::BULGARIAN            => "Βουλγαρικά",
                    self::CHINESE_CHINA        => "Κινέζικα (Κίνα)",
                    self::CHINESE_TAIWAN       => "Κινέζικα (Ταϊβάν)",
                    self::CROATIAN             => "Κροατικά",
                    self::CZECH                => "Τσεχικά",
                    self::DANISH               => "Δανικά",
                    self::DUTCH                => "Ολλανδικά",
                    self::ENGLISH_UK           => "Αγγλικά (Ηνωμένο Βασίλειο)",
                    self::ENGLISH_US           => "Αγγλικά (ΗΠΑ)",
                    self::FINNISH              => "Φινλανδικά",
                    self::FRENCH               => "Γαλλικά",
                    self::GERMAN               => "Γερμανικά",
                    self::GREEK                => self::GREEK->getNativeName(),
                    self::HINDI                => "Χίντι",
                    self::HUNGARIAN            => "Ουγγρικά",
                    self::INDONESIAN           => "Ινδονησιακά",
                    self::ITALIAN              => "Ιταλικά",
                    self::JAPANESE             => "Ιαπωνικά",
                    self::KOREAN               => "Κορεατικά",
                    self::LITHUANIAN           => "Λιθουανικά",
                    self::NORWEGIAN            => "Νορβηγικά",
                    self::POLISH               => "Πολωνικά",
                    self::PORTUGUESE_BRAZILIAN => "Πορτογαλικά (Βραζιλία)",
                    self::ROMANIAN_ROMANIA     => "Ρουμανικά",
                    self::RUSSIAN              => "Ρωσικά",
                    self::SPANISH              => "Ισπανικά",
                    self::SPANISH_LATAM        => "Ισπανικά (Λατινική Αμερική)",
                    self::SWEDISH              => "Σουηδικά",
                    self::THAI                 => "Ταϊλανδέζικα",
                    self::TURKISH              => "Τουρκικά",
                    self::UKRAINIAN            => "Ουκρανικά",
                    self::VIETNAMESE           => "Βιετναμέζικα",
                    default                    => self::GREEK->getLanguageName()
                };
            case self::HINDI:
                return match ($this) {
                    self::BULGARIAN            => "बुल्गेरियाई",
                    self::CHINESE_CHINA        => "चीनी (चीन)",
                    self::CHINESE_TAIWAN       => "चीनी (ताइवान)",
                    self::CROATIAN             => "क्रोएशियाई",
                    self::CZECH                => "चेक",
                    self::DANISH               => "डेनिश",
                    self::DUTCH                => "डच",
                    self::ENGLISH_UK           => "अंग्रेज़ी (यूके)",
                    self::ENGLISH_US           => "अंग्रेज़ी (यूएस)",
                    self::FINNISH              => "फिनिश",
                    self::FRENCH               => "फ्रेंच",
                    self::GERMAN               => "जर्मन",
                    self::GREEK                => "ग्रीक",
                    self::HINDI                => self::HINDI->getNativeName(),
                    self::HUNGARIAN            => "हंगेरियन",
                    self::INDONESIAN           => "इंडोनेशियाई",
                    self::ITALIAN              => "इतालवी",
                    self::JAPANESE             => "जापानी",
                    self::KOREAN               => "कोरियाई",
                    self::LITHUANIAN           => "लिथुआनियाई",
                    self::NORWEGIAN            => "नॉर्वेजियन",
                    self::POLISH               => "पोलिश",
                    self::PORTUGUESE_BRAZILIAN => "पुर्तगाली (ब्राज़ील)",
                    self::ROMANIAN_ROMANIA     => "रोमानियाई",
                    self::RUSSIAN              => "रूसी",
                    self::SPANISH              => "स्पेनिश",
                    self::SPANISH_LATAM        => "स्पेनिश (लैटिन अमेरिका)",
                    self::SWEDISH              => "स्वीडिश",
                    self::THAI                 => "थाई",
                    self::TURKISH              => "तुर्की",
                    self::UKRAINIAN            => "यूक्रेनी",
                    self::VIETNAMESE           => "वियतनामी",
                    default                    => self::HINDI->getLanguageName()
                };
            case self::HUNGARIAN:
                return match ($this) {
                    self::BULGARIAN            => "Bolgár",
                    self::CHINESE_CHINA        => "Kínai (Kína)",
                    self::CHINESE_TAIWAN       => "Kínai (Tajvan)",
                    self::CROATIAN             => "Horvát",
                    self::CZECH                => "Cseh",
                    self::DANISH               => "Dán",
                    self::DUTCH                => "Holland",
                    self::ENGLISH_UK           => "Angol (Egyesült Királyság)",
                    self::ENGLISH_US           => "Angol (Amerikai Egyesült Államok)",
                    self::FINNISH              => "Finn",
                    self::FRENCH               => "Francia",
                    self::GERMAN               => "Német",
                    self::GREEK                => "Görög",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => self::HUNGARIAN->getNativeName(),
                    self::INDONESIAN           => "Indonéz",
                    self::ITALIAN              => "Olasz",
                    self::JAPANESE             => "Japán",
                    self::KOREAN               => "Koreai",
                    self::LITHUANIAN           => "Litván",
                    self::NORWEGIAN            => "Norvég",
                    self::POLISH               => "Lengyel",
                    self::PORTUGUESE_BRAZILIAN => "Portugál (Brazília)",
                    self::ROMANIAN_ROMANIA     => "Román",
                    self::RUSSIAN              => "Orosz",
                    self::SPANISH              => "Spanyol",
                    self::SPANISH_LATAM        => "Spanyol (Latin-Amerika)",
                    self::SWEDISH              => "Svéd",
                    self::THAI                 => "Thai",
                    self::TURKISH              => "Török",
                    self::UKRAINIAN            => "Ukrán",
                    self::VIETNAMESE           => "Vietnámi",
                    default                    => self::HUNGARIAN->getLanguageName()
                };
            case self::INDONESIAN:
                return match ($this) {
                    self::BULGARIAN            => "Bulgaria",
                    self::CHINESE_CHINA        => "Cina (China)",
                    self::CHINESE_TAIWAN       => "Cina (Taiwan)",
                    self::CROATIAN             => "Kroasia",
                    self::CZECH                => "Ceko",
                    self::DANISH               => "Denmark",
                    self::DUTCH                => "Belanda",
                    self::ENGLISH_UK           => "Inggris (Britania Raya)",
                    self::ENGLISH_US           => "Inggris (Amerika Serikat)",
                    self::FINNISH              => "Finlandia",
                    self::FRENCH               => "Perancis",
                    self::GERMAN               => "Jerman",
                    self::GREEK                => "Yunani",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Hungaria",
                    self::INDONESIAN           => self::INDONESIAN->getNativeName(),
                    self::ITALIAN              => "Italia",
                    self::JAPANESE             => "Jepang",
                    self::KOREAN               => "Korea",
                    self::LITHUANIAN           => "Lituania",
                    self::NORWEGIAN            => "Norwegia",
                    self::POLISH               => "Polandia",
                    self::PORTUGUESE_BRAZILIAN => "Portugis (Brasil)",
                    self::ROMANIAN_ROMANIA     => "Rumania",
                    self::RUSSIAN              => "Rusia",
                    self::SPANISH              => "Spanyol",
                    self::SPANISH_LATAM        => "Spanyol (Amerika Latin)",
                    self::SWEDISH              => "Swedia",
                    self::THAI                 => "Thailand",
                    self::TURKISH              => "Turki",
                    self::UKRAINIAN            => "Ukraina",
                    self::VIETNAMESE           => "Vietnam",
                    default                    => self::INDONESIAN->getLanguageName()
                };
            case self::ITALIAN:
                return match ($this) {
                    self::BULGARIAN            => "Bulgaro",
                    self::CHINESE_CHINA        => "Cinese (Cina)",
                    self::CHINESE_TAIWAN       => "Cinese (Taiwan)",
                    self::CROATIAN             => "Croato",
                    self::CZECH                => "Ceco",
                    self::DANISH               => "Danese",
                    self::DUTCH                => "Olandese",
                    self::ENGLISH_UK           => "Inglese (Regno Unito)",
                    self::ENGLISH_US           => "Inglese (Stati Uniti)",
                    self::FINNISH              => "Finlandese",
                    self::FRENCH               => "Francese",
                    self::GERMAN               => "Tedesco",
                    self::GREEK                => "Greco",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Ungherese",
                    self::INDONESIAN           => "Indonesiano",
                    self::ITALIAN              => self::ITALIAN->getNativeName(),
                    self::JAPANESE             => "Giapponese",
                    self::KOREAN               => "Coreano",
                    self::LITHUANIAN           => "Lituano",
                    self::NORWEGIAN            => "Norvegese",
                    self::POLISH               => "Polacco",
                    self::PORTUGUESE_BRAZILIAN => "Portoghese (Brasile)",
                    self::ROMANIAN_ROMANIA     => "Rumeno",
                    self::RUSSIAN              => "Russo",
                    self::SPANISH              => "Spagnolo",
                    self::SPANISH_LATAM        => "Spagnolo (America Latina)",
                    self::SWEDISH              => "Svedese",
                    self::THAI                 => "Tailandese",
                    self::TURKISH              => "Turco",
                    self::UKRAINIAN            => "Ucraino",
                    self::VIETNAMESE           => "Vietnamita",
                    default                    => self::ITALIAN->getLanguageName()
                };
            case self::JAPANESE:
                return match ($this) {
                    self::BULGARIAN            => "ブルガリア語",
                    self::CHINESE_CHINA        => "中国語（中国）",
                    self::CHINESE_TAIWAN       => "中国語（台湾）",
                    self::CROATIAN             => "クロアチア語",
                    self::CZECH                => "チェコ語",
                    self::DANISH               => "デンマーク語",
                    self::DUTCH                => "オランダ語",
                    self::ENGLISH_UK           => "英語（イギリス）",
                    self::ENGLISH_US           => "英語（アメリカ）",
                    self::FINNISH              => "フィンランド語",
                    self::FRENCH               => "フランス語",
                    self::GERMAN               => "ドイツ語",
                    self::GREEK                => "ギリシャ語",
                    self::HINDI                => "ヒンディー語",
                    self::HUNGARIAN            => "ハンガリー語",
                    self::INDONESIAN           => "インドネシア語",
                    self::ITALIAN              => "イタリア語",
                    self::JAPANESE             => self::JAPANESE->getNativeName(),
                    self::KOREAN               => "韓国語",
                    self::LITHUANIAN           => "リトアニア語",
                    self::NORWEGIAN            => "ノルウェー語",
                    self::POLISH               => "ポーランド語",
                    self::PORTUGUESE_BRAZILIAN => "ポルトガル語（ブラジル）",
                    self::ROMANIAN_ROMANIA     => "ルーマニア語",
                    self::RUSSIAN              => "ロシア語",
                    self::SPANISH              => "スペイン語",
                    self::SPANISH_LATAM        => "スペイン語（ラテンアメリカ）",
                    self::SWEDISH              => "スウェーデン語",
                    self::THAI                 => "タイ語",
                    self::TURKISH              => "トルコ語",
                    self::UKRAINIAN            => "ウクライナ語",
                    self::VIETNAMESE           => "ベトナム語",
                    default                    => self::JAPANESE->getLanguageName()
                };
            case self::KOREAN:
                return match ($this) {
                    self::BULGARIAN            => "불가리아어",
                    self::CHINESE_CHINA        => "중국어 (중국)",
                    self::CHINESE_TAIWAN       => "중국어 (대만)",
                    self::CROATIAN             => "크로아티아어",
                    self::CZECH                => "체코어",
                    self::DANISH               => "덴마크어",
                    self::DUTCH                => "네덜란드어",
                    self::ENGLISH_UK           => "영어 (영국)",
                    self::ENGLISH_US           => "영어 (미국)",
                    self::FINNISH              => "핀란드어",
                    self::FRENCH               => "프랑스어",
                    self::GERMAN               => "독일어",
                    self::GREEK                => "그리스어",
                    self::HINDI                => "힌디어",
                    self::HUNGARIAN            => "헝가리어",
                    self::INDONESIAN           => "인도네시아어",
                    self::ITALIAN              => "이탈리아어",
                    self::JAPANESE             => "일본어",
                    self::KOREAN               => self::KOREAN->getNativeName(),
                    self::LITHUANIAN           => "리투아니아어",
                    self::NORWEGIAN            => "노르웨이어",
                    self::POLISH               => "폴란드어",
                    self::PORTUGUESE_BRAZILIAN => "포르투갈어 (브라질)",
                    self::ROMANIAN_ROMANIA     => "루마니아어",
                    self::RUSSIAN              => "러시아어",
                    self::SPANISH              => "스페인어",
                    self::SPANISH_LATAM        => "스페인어 (라틴 아메리카)",
                    self::SWEDISH              => "스웨덴어",
                    self::THAI                 => "태국어",
                    self::TURKISH              => "터키어",
                    self::UKRAINIAN            => "우크라이나어",
                    self::VIETNAMESE           => "베트남어",
                    default                    => self::KOREAN->getLanguageName()
                };
            case self::LITHUANIAN:
                return match ($this) {
                    self::BULGARIAN            => "Bulgarų",
                    self::CHINESE_CHINA        => "Kinų (Kinija)",
                    self::CHINESE_TAIWAN       => "Kinų (Taivanas)",
                    self::CROATIAN             => "Kroatų",
                    self::CZECH                => "Čekų",
                    self::DANISH               => "Danų",
                    self::DUTCH                => "Olandų",
                    self::ENGLISH_UK           => "Anglų (JK)",
                    self::ENGLISH_US           => "Anglų (JAV)",
                    self::FINNISH              => "Suomių",
                    self::FRENCH               => "Prancūzų",
                    self::GERMAN               => "Vokiečių",
                    self::GREEK                => "Graikų",
                    self::HINDI                => "Hindų",
                    self::HUNGARIAN            => "Vengrų",
                    self::INDONESIAN           => "Indoneziečių",
                    self::ITALIAN              => "Italų",
                    self::JAPANESE             => "Japonų",
                    self::KOREAN               => "Korėjiečių",
                    self::LITHUANIAN           => self::LITHUANIAN->getNativeName(),
                    self::NORWEGIAN            => "Norvegų",
                    self::POLISH               => "Lenkų",
                    self::PORTUGUESE_BRAZILIAN => "Portugalų (Brazilija)",
                    self::ROMANIAN_ROMANIA     => "Rumunų",
                    self::RUSSIAN              => "Rusų",
                    self::SPANISH              => "Ispanų",
                    self::SPANISH_LATAM        => "Ispanų (Lotynų Amerika)",
                    self::SWEDISH              => "Švedų",
                    self::THAI                 => "Tajų",
                    self::TURKISH              => "Turkų",
                    self::UKRAINIAN            => "Ukrainiečių",
                    self::VIETNAMESE           => "Vietnamiečių",
                    default                    => self::LITHUANIAN->getLanguageName()
                };
            case self::NORWEGIAN:
                return match ($this) {
                    self::BULGARIAN            => "Bulgarsk",
                    self::CHINESE_CHINA        => "Kinesisk (Kina)",
                    self::CHINESE_TAIWAN       => "Kinesisk (Taiwan)",
                    self::CROATIAN             => "Kroatisk",
                    self::CZECH                => "Tsjekkisk",
                    self::DANISH               => "Dansk",
                    self::DUTCH                => "Nederlandsk",
                    self::ENGLISH_UK           => "Engelsk (Storbritannia)",
                    self::ENGLISH_US           => "Engelsk (USA)",
                    self::FINNISH              => "Finsk",
                    self::FRENCH               => "Fransk",
                    self::GERMAN               => "Tysk",
                    self::GREEK                => "Gresk",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Ungarsk",
                    self::INDONESIAN           => "Indonesisk",
                    self::ITALIAN              => "Italiensk",
                    self::JAPANESE             => "Japansk",
                    self::KOREAN               => "Koreansk",
                    self::LITHUANIAN           => "Litauisk",
                    self::NORWEGIAN            => self::NORWEGIAN->getNativeName(),
                    self::POLISH               => "Polsk",
                    self::PORTUGUESE_BRAZILIAN => "Portugisisk (Brasil)",
                    self::ROMANIAN_ROMANIA     => "Rumensk",
                    self::RUSSIAN              => "Russisk",
                    self::SPANISH              => "Spansk",
                    self::SPANISH_LATAM        => "Spansk (Latin-Amerika)",
                    self::SWEDISH              => "Svensk",
                    self::THAI                 => "Thai",
                    self::TURKISH              => "Tyrkisk",
                    self::UKRAINIAN            => "Ukrainsk",
                    self::VIETNAMESE           => "Vietnamesisk",
                    default                    => self::NORWEGIAN->getLanguageName()
                };
            case self::POLISH:
                return match ($this) {
                    self::BULGARIAN            => "Bułgarski",
                    self::CHINESE_CHINA        => "Chiński (Chiny)",
                    self::CHINESE_TAIWAN       => "Chiński (Tajwan)",
                    self::CROATIAN             => "Chorwacki",
                    self::CZECH                => "Czeski",
                    self::DANISH               => "Duński",
                    self::DUTCH                => "Holenderski",
                    self::ENGLISH_UK           => "Angielski (Wielka Brytania)",
                    self::ENGLISH_US           => "Angielski (USA)",
                    self::FINNISH              => "Fiński",
                    self::FRENCH               => "Francuski",
                    self::GERMAN               => "Niemiecki",
                    self::GREEK                => "Grecki",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Węgierski",
                    self::INDONESIAN           => "Indonezyjski",
                    self::ITALIAN              => "Włoski",
                    self::JAPANESE             => "Japoński",
                    self::KOREAN               => "Koreański",
                    self::LITHUANIAN           => "Litewski",
                    self::NORWEGIAN            => "Norweski",
                    self::POLISH               => self::POLISH->getNativeName(),
                    self::PORTUGUESE_BRAZILIAN => "Portugalski (Brazylia)",
                    self::ROMANIAN_ROMANIA     => "Rumuński",
                    self::RUSSIAN              => "Rosyjski",
                    self::SPANISH              => "Hiszpański",
                    self::SPANISH_LATAM        => "Hiszpański (Ameryka Łacińska)",
                    self::SWEDISH              => "Szwedzki",
                    self::THAI                 => "Tajski",
                    self::TURKISH              => "Turecki",
                    self::UKRAINIAN            => "Ukraiński",
                    self::VIETNAMESE           => "Wietnamski",
                    default                    => self::POLISH->getLanguageName()
                };
            case self::PORTUGUESE_BRAZILIAN:
                return match ($this) {
                    self::BULGARIAN            => "Búlgaro",
                    self::CHINESE_CHINA        => "Chinês (China)",
                    self::CHINESE_TAIWAN       => "Chinês (Taiwan)",
                    self::CROATIAN             => "Croata",
                    self::CZECH                => "Tcheco",
                    self::DANISH               => "Dinamarquês",
                    self::DUTCH                => "Holandês",
                    self::ENGLISH_UK           => "Inglês (Reino Unido)",
                    self::ENGLISH_US           => "Inglês (EUA)",
                    self::FINNISH              => "Finlandês",
                    self::FRENCH               => "Francês",
                    self::GERMAN               => "Alemão",
                    self::GREEK                => "Grego",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Húngaro",
                    self::INDONESIAN           => "Indonésio",
                    self::ITALIAN              => "Italiano",
                    self::JAPANESE             => "Japonês",
                    self::KOREAN               => "Coreano",
                    self::LITHUANIAN           => "Lituano",
                    self::NORWEGIAN            => "Norueguês",
                    self::POLISH               => "Polonês",
                    self::PORTUGUESE_BRAZILIAN => self::PORTUGUESE_BRAZILIAN->getNativeName(),
                    self::ROMANIAN_ROMANIA     => "Romeno",
                    self::RUSSIAN              => "Russo",
                    self::SPANISH              => "Espanhol",
                    self::SPANISH_LATAM        => "Espanhol (Latinoamérica)",
                    self::SWEDISH              => "Sueco",
                    self::THAI                 => "Tailandês",
                    self::TURKISH              => "Turco",
                    self::UKRAINIAN            => "Ucraniano",
                    self::VIETNAMESE           => "Vietnamita",
                    default                    => self::PORTUGUESE_BRAZILIAN->getLanguageName()
                };
            case self::ROMANIAN_ROMANIA:
                return match ($this) {
                    self::BULGARIAN            => "Bulgară",
                    self::CHINESE_CHINA        => "Chineză (China)",
                    self::CHINESE_TAIWAN       => "Chineză (Taiwan)",
                    self::CROATIAN             => "Croată",
                    self::CZECH                => "Cehă",
                    self::DANISH               => "Daneză",
                    self::DUTCH                => "Olandeză",
                    self::ENGLISH_UK           => "Engleză (Regatul Unit)",
                    self::ENGLISH_US           => "Engleză (SUA)",
                    self::FINNISH              => "Finlandeză",
                    self::FRENCH               => "Franceză",
                    self::GERMAN               => "Germană",
                    self::GREEK                => "Greacă",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Maghiară",
                    self::INDONESIAN           => "Indoneziană",
                    self::ITALIAN              => "Italiană",
                    self::JAPANESE             => "Japoneză",
                    self::KOREAN               => "Coreeană",
                    self::LITHUANIAN           => "Lituaniană",
                    self::NORWEGIAN            => "Norvegiană",
                    self::POLISH               => "Poloneză",
                    self::PORTUGUESE_BRAZILIAN => "Portugheză (Brazilia)",
                    self::ROMANIAN_ROMANIA     => self::ROMANIAN_ROMANIA->getNativeName(),
                    self::RUSSIAN              => "Rusă",
                    self::SPANISH              => "Spaniolă",
                    self::SPANISH_LATAM        => "Spaniolă (America Latină)",
                    self::SWEDISH              => "Suedeză",
                    self::THAI                 => "Thailandeză",
                    self::TURKISH              => "Turcă",
                    self::UKRAINIAN            => "Ucraineană",
                    self::VIETNAMESE           => "Vietnameză",
                    default                    => self::ROMANIAN_ROMANIA->getLanguageName()
                };
            case self::RUSSIAN:
                return match ($this) {
                    self::BULGARIAN            => "Болгарский",
                    self::CHINESE_CHINA        => "Китайский (Китай)",
                    self::CHINESE_TAIWAN       => "Китайский (Тайвань)",
                    self::CROATIAN             => "Хорватский",
                    self::CZECH                => "Чешский",
                    self::DANISH               => "Датский",
                    self::DUTCH                => "Голландский",
                    self::ENGLISH_UK           => "Английский (Великобритания)",
                    self::ENGLISH_US           => "Английский (США)",
                    self::FINNISH              => "Финский",
                    self::FRENCH               => "Французский",
                    self::GERMAN               => "Немецкий",
                    self::GREEK                => "Греческий",
                    self::HINDI                => "Хинди",
                    self::HUNGARIAN            => "Венгерский",
                    self::INDONESIAN           => "Индонезийский",
                    self::ITALIAN              => "Итальянский",
                    self::JAPANESE             => "Японский",
                    self::KOREAN               => "Корейский",
                    self::LITHUANIAN           => "Литовский",
                    self::NORWEGIAN            => "Норвежский",
                    self::POLISH               => "Польский",
                    self::PORTUGUESE_BRAZILIAN => "Португальский (Бразилия)",
                    self::ROMANIAN_ROMANIA     => "Румынский",
                    self::RUSSIAN              => self::RUSSIAN->getNativeName(),
                    self::SPANISH              => "Испанский",
                    self::SPANISH_LATAM        => "Испанский (Латинская Америка)",
                    self::SWEDISH              => "Шведский",
                    self::THAI                 => "Тайский",
                    self::TURKISH              => "Турецкий",
                    self::UKRAINIAN            => "Украинский",
                    self::VIETNAMESE           => "Вьетнамский",
                    default                    => self::RUSSIAN->getLanguageName()
                };
            case self::SPANISH:
                return match ($this) {
                    self::BULGARIAN            => "Búlgaro",
                    self::CHINESE_CHINA        => "Chino (China)",
                    self::CHINESE_TAIWAN       => "Chino (Taiwán)",
                    self::CROATIAN             => "Croata",
                    self::CZECH                => "Checo",
                    self::DANISH               => "Danés",
                    self::DUTCH                => "Holandés",
                    self::ENGLISH_UK           => "Inglés (Reino Unido)",
                    self::ENGLISH_US           => "Inglés (EE. UU.)",
                    self::FINNISH              => "Finlandés",
                    self::FRENCH               => "Francés",
                    self::GERMAN               => "Alemán",
                    self::GREEK                => "Griego",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Húngaro",
                    self::INDONESIAN           => "Indonesio",
                    self::ITALIAN              => "Italiano",
                    self::JAPANESE             => "Japonés",
                    self::KOREAN               => "Coreano",
                    self::LITHUANIAN           => "Lituano",
                    self::NORWEGIAN            => "Noruego",
                    self::POLISH               => "Polaco",
                    self::PORTUGUESE_BRAZILIAN => "Portugués (Brasil)",
                    self::ROMANIAN_ROMANIA     => "Rumano",
                    self::RUSSIAN              => "Ruso",
                    self::SPANISH              => self::SPANISH->getNativeName(),
                    self::SPANISH_LATAM        => "Español (Latinoamérica)",
                    self::SWEDISH              => "Sueco",
                    self::THAI                 => "Tailandés",
                    self::TURKISH              => "Turco",
                    self::UKRAINIAN            => "Ucraniano",
                    self::VIETNAMESE           => "Vietnamita",
                    default                    => self::SPANISH->getLanguageName()
                };
            case self::SPANISH_LATAM:
                return match ($this) {
                    self::BULGARIAN            => "Búlgaro",
                    self::CHINESE_CHINA        => "Chino (China)",
                    self::CHINESE_TAIWAN       => "Chino (Taiwán)",
                    self::CROATIAN             => "Croata",
                    self::CZECH                => "Checo",
                    self::DANISH               => "Danés",
                    self::DUTCH                => "Neerlandés",
                    self::ENGLISH_UK           => "Inglés (Reino Unido)",
                    self::ENGLISH_US           => "Inglés (EE. UU.)",
                    self::FINNISH              => "Finlandés",
                    self::FRENCH               => "Francés",
                    self::GERMAN               => "Alemán",
                    self::GREEK                => "Griego",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Húngaro",
                    self::INDONESIAN           => "Indonesio",
                    self::ITALIAN              => "Italiano",
                    self::JAPANESE             => "Japonés",
                    self::KOREAN               => "Coreano",
                    self::LITHUANIAN           => "Lituano",
                    self::NORWEGIAN            => "Noruego",
                    self::POLISH               => "Polaco",
                    self::PORTUGUESE_BRAZILIAN => "Portugués (Brasil)",
                    self::ROMANIAN_ROMANIA     => "Rumano",
                    self::RUSSIAN              => "Ruso",
                    self::SPANISH              => "Español (España)",
                    self::SPANISH_LATAM        => self::SPANISH_LATAM->getNativeName(),
                    self::SWEDISH              => "Sueco",
                    self::THAI                 => "Tailandés",
                    self::TURKISH              => "Turco",
                    self::UKRAINIAN            => "Ucraniano",
                    self::VIETNAMESE           => "Vietnamita",
                    default                    => self::SPANISH_LATAM->getLanguageName()
                };
            case self::SWEDISH:
                return match ($this) {
                    self::BULGARIAN            => "Bulgariska",
                    self::CHINESE_CHINA        => "Kinesiska (Kina)",
                    self::CHINESE_TAIWAN       => "Kinesiska (Taiwan)",
                    self::CROATIAN             => "Kroatiska",
                    self::CZECH                => "Tjeckiska",
                    self::DANISH               => "Danska",
                    self::DUTCH                => "Nederländska",
                    self::ENGLISH_UK           => "Engelska (Storbritannien)",
                    self::ENGLISH_US           => "Engelska (USA)",
                    self::FINNISH              => "Finska",
                    self::FRENCH               => "Franska",
                    self::GERMAN               => "Tyska",
                    self::GREEK                => "Grekiska",
                    self::HINDI                => "Hindi",
                    self::HUNGARIAN            => "Ungerska",
                    self::INDONESIAN           => "Indonesiska",
                    self::ITALIAN              => "Italienska",
                    self::JAPANESE             => "Japanska",
                    self::KOREAN               => "Koreanska",
                    self::LITHUANIAN           => "Litauiska",
                    self::NORWEGIAN            => "Norska",
                    self::POLISH               => "Polska",
                    self::PORTUGUESE_BRAZILIAN => "Portugisiska (Brasilien)",
                    self::ROMANIAN_ROMANIA     => "Rumänska",
                    self::RUSSIAN              => "Ryska",
                    self::SPANISH              => "Spanska (Spanien)",
                    self::SPANISH_LATAM        => "Spanska (Latinamerika)",
                    self::SWEDISH              => self::SWEDISH->getNativeName(),
                    self::THAI                 => "Thailändska",
                    self::TURKISH              => "Turkiska",
                    self::UKRAINIAN            => "Ukrainska",
                    self::VIETNAMESE           => "Vietnamesiska",
                    default                    => self::SWEDISH->getLanguageName()
                };
            case self::THAI:
                return match ($this) {
                    self::BULGARIAN            => "บัลแกเรีย",
                    self::CHINESE_CHINA        => "จีน (จีนแผ่นดินใหญ่)",
                    self::CHINESE_TAIWAN       => "จีน (ไต้หวัน)",
                    self::CROATIAN             => "โครเอเชีย",
                    self::CZECH                => "เช็ก",
                    self::DANISH               => "เดนมาร์ก",
                    self::DUTCH                => "ดัตช์",
                    self::ENGLISH_UK           => "อังกฤษ (สหราชอาณาจักร)",
                    self::ENGLISH_US           => "อังกฤษ (สหรัฐอเมริกา)",
                    self::FINNISH              => "ฟินแลนด์",
                    self::FRENCH               => "ฝรั่งเศส",
                    self::GERMAN               => "เยอรมัน",
                    self::GREEK                => "กรีก",
                    self::HINDI                => "ฮินดี",
                    self::HUNGARIAN            => "ฮังการี",
                    self::INDONESIAN           => "อินโดนีเซีย",
                    self::ITALIAN              => "อิตาลี",
                    self::JAPANESE             => "ญี่ปุ่น",
                    self::KOREAN               => "เกาหลี",
                    self::LITHUANIAN           => "ลิทัวเนีย",
                    self::NORWEGIAN            => "นอร์เวย์",
                    self::POLISH               => "โปแลนด์",
                    self::PORTUGUESE_BRAZILIAN => "โปรตุเกส (บราซิล)",
                    self::ROMANIAN_ROMANIA     => "โรมาเนีย",
                    self::RUSSIAN              => "รัสเซีย",
                    self::SPANISH              => "สเปน (สเปน)",
                    self::SPANISH_LATAM        => "สเปน (ละตินอเมริกา)",
                    self::SWEDISH              => "สวีเดน",
                    self::THAI                 => self::THAI->getNativeName(),
                    self::TURKISH              => "ตุรกี",
                    self::UKRAINIAN            => "ยูเครน",
                    self::VIETNAMESE           => "เวียดนาม",
                    default                    => self::THAI->getLanguageName()
                };
            case self::TURKISH:
                return match ($this) {
                    self::BULGARIAN            => "Bulgarca",
                    self::CHINESE_CHINA        => "Çince (Çin Anakarası)",
                    self::CHINESE_TAIWAN       => "Çince (Tayvan)",
                    self::CROATIAN             => "Hırvatça",
                    self::CZECH                => "Çekçe",
                    self::DANISH               => "Danca",
                    self::DUTCH                => "Felemenkçe",
                    self::ENGLISH_UK           => "İngilizce (İngiltere)",
                    self::ENGLISH_US           => "İngilizce (Amerika)",
                    self::FINNISH              => "Fince",
                    self::FRENCH               => "Fransızca",
                    self::GERMAN               => "Almanca",
                    self::GREEK                => "Yunanca",
                    self::HINDI                => "Hintçe",
                    self::HUNGARIAN            => "Macarca",
                    self::INDONESIAN           => "Endonezce",
                    self::ITALIAN              => "İtalyanca",
                    self::JAPANESE             => "Japonca",
                    self::KOREAN               => "Korece",
                    self::LITHUANIAN           => "Litvanca",
                    self::NORWEGIAN            => "Norveççe",
                    self::POLISH               => "Lehçe",
                    self::PORTUGUESE_BRAZILIAN => "Portekizce (Brezilya)",
                    self::ROMANIAN_ROMANIA     => "Romence",
                    self::RUSSIAN              => "Rusça",
                    self::SPANISH              => "İspanyolca (İspanya)",
                    self::SPANISH_LATAM        => "İspanyolca (Latin Amerika)",
                    self::SWEDISH              => "İsveççe",
                    self::THAI                 => "Tayca",
                    self::TURKISH              => self::TURKISH->getNativeName(),
                    self::UKRAINIAN            => "Ukraynaca",
                    self::VIETNAMESE           => "Vietnamca",
                    default                    => self::TURKISH->getLanguageName()
                };
            case self::UKRAINIAN:
                return match ($this) {
                    self::BULGARIAN            => "Болгарська",
                    self::CHINESE_CHINA        => "Китайська (Китай)",
                    self::CHINESE_TAIWAN       => "Китайська (Тайвань)",
                    self::CROATIAN             => "Хорватська",
                    self::CZECH                => "Чеська",
                    self::DANISH               => "Данська",
                    self::DUTCH                => "Нідерландська",
                    self::ENGLISH_UK           => "Англійська (Велика Британія)",
                    self::ENGLISH_US           => "Англійська (США)",
                    self::FINNISH              => "Фінська",
                    self::FRENCH               => "Французька",
                    self::GERMAN               => "Німецька",
                    self::GREEK                => "Грецька",
                    self::HINDI                => "Гінді",
                    self::HUNGARIAN            => "Угорська",
                    self::INDONESIAN           => "Індонезійська",
                    self::ITALIAN              => "Італійська",
                    self::JAPANESE             => "Японська",
                    self::KOREAN               => "Корейська",
                    self::LITHUANIAN           => "Литовська",
                    self::NORWEGIAN            => "Норвезька",
                    self::POLISH               => "Польська",
                    self::PORTUGUESE_BRAZILIAN => "Португальська (Бразилія)",
                    self::ROMANIAN_ROMANIA     => "Румунська",
                    self::RUSSIAN              => "Російська",
                    self::SPANISH              => "Іспанська (Іспанія)",
                    self::SPANISH_LATAM        => "Іспанська (Латинська Америка)",
                    self::SWEDISH              => "Шведська",
                    self::THAI                 => "Тайська",
                    self::TURKISH              => "Турецька",
                    self::UKRAINIAN            => self::UKRAINIAN->getNativeName(),
                    self::VIETNAMESE           => "В'єтнамська",
                    default                    => self::UKRAINIAN->getLanguageName()
                };
            case self::VIETNAMESE:
                return match ($this) {
                    self::BULGARIAN            => "Tiếng Bulgaria",
                    self::CHINESE_CHINA        => "Tiếng Trung (Trung Quốc)",
                    self::CHINESE_TAIWAN       => "Tiếng Trung (Đài Loan)",
                    self::CROATIAN             => "Tiếng Croatia",
                    self::CZECH                => "Tiếng Séc",
                    self::DANISH               => "Tiếng Đan Mạch",
                    self::DUTCH                => "Tiếng Hà Lan",
                    self::ENGLISH_UK           => "Tiếng Anh (Vương quốc Anh)",
                    self::ENGLISH_US           => "Tiếng Anh (Hoa Kỳ)",
                    self::FINNISH              => "Tiếng Phần Lan",
                    self::FRENCH               => "Tiếng Pháp",
                    self::GERMAN               => "Tiếng Đức",
                    self::GREEK                => "Tiếng Hy Lạp",
                    self::HINDI                => "Tiếng Hindi",
                    self::HUNGARIAN            => "Tiếng Hungary",
                    self::INDONESIAN           => "Tiếng Indonesia",
                    self::ITALIAN              => "Tiếng Ý",
                    self::JAPANESE             => "Tiếng Nhật",
                    self::KOREAN               => "Tiếng Hàn",
                    self::LITHUANIAN           => "Tiếng Lithuania",
                    self::NORWEGIAN            => "Tiếng Na Uy",
                    self::POLISH               => "Tiếng Ba Lan",
                    self::PORTUGUESE_BRAZILIAN => "Tiếng Bồ Đào Nha (Brazil)",
                    self::ROMANIAN_ROMANIA     => "Tiếng Romania",
                    self::RUSSIAN              => "Tiếng Nga",
                    self::SPANISH              => "Tiếng Tây Ban Nha (Tây Ban Nha)",
                    self::SPANISH_LATAM        => "Tiếng Tây Ban Nha (Mỹ Latinh)",
                    self::SWEDISH              => "Tiếng Thụy Điển",
                    self::THAI                 => "Tiếng Thái",
                    self::TURKISH              => "Tiếng Thổ Nhĩ Kỳ",
                    self::UKRAINIAN            => "Tiếng Ukraina",
                    self::VIETNAMESE           => self::VIETNAMESE->getNativeName(),
                    default                    => self::VIETNAMESE->getLanguageName()
                };
            default: // ENGLISH_US | ENGLISH_UK
                return match ($this) {
                    self::BULGARIAN            => self::BULGARIAN->getLanguageName(),
                    self::CHINESE_CHINA        => self::CHINESE_CHINA->getLanguageName(),
                    self::CHINESE_TAIWAN       => self::CHINESE_TAIWAN->getLanguageName(),
                    self::CROATIAN             => self::CROATIAN->getLanguageName(),
                    self::CZECH                => self::CZECH->getLanguageName(),
                    self::DANISH               => self::DANISH->getLanguageName(),
                    self::DUTCH                => self::DUTCH->getLanguageName(),
                    self::ENGLISH_UK           => self::ENGLISH_UK->getLanguageName(),
                    self::ENGLISH_US           => self::ENGLISH_US->getLanguageName(),
                    self::FINNISH              => self::FINNISH->getLanguageName(),
                    self::FRENCH               => self::FRENCH->getLanguageName(),
                    self::GERMAN               => self::GERMAN->getLanguageName(),
                    self::GREEK                => self::GREEK->getLanguageName(),
                    self::HINDI                => self::HINDI->getLanguageName(),
                    self::HUNGARIAN            => self::HUNGARIAN->getLanguageName(),
                    self::INDONESIAN           => self::INDONESIAN->getLanguageName(),
                    self::ITALIAN              => self::ITALIAN->getLanguageName(),
                    self::JAPANESE             => self::JAPANESE->getLanguageName(),
                    self::KOREAN               => self::KOREAN->getLanguageName(),
                    self::LITHUANIAN           => self::LITHUANIAN->getLanguageName(),
                    self::NORWEGIAN            => self::NORWEGIAN->getLanguageName(),
                    self::POLISH               => self::POLISH->getLanguageName(),
                    self::PORTUGUESE_BRAZILIAN => self::PORTUGUESE_BRAZILIAN->getLanguageName(),
                    self::ROMANIAN_ROMANIA     => self::ROMANIAN_ROMANIA->getLanguageName(),
                    self::RUSSIAN              => self::RUSSIAN->getLanguageName(),
                    self::SPANISH              => self::SPANISH->getLanguageName(),
                    self::SPANISH_LATAM        => self::SPANISH_LATAM->getLanguageName(),
                    self::SWEDISH              => self::SWEDISH->getLanguageName(),
                    self::THAI                 => self::THAI->getLanguageName(),
                    self::TURKISH              => self::TURKISH->getLanguageName(),
                    self::UKRAINIAN            => self::UKRAINIAN->getLanguageName(),
                    self::VIETNAMESE           => self::VIETNAMESE->getLanguageName(),
                    default                    => self::ENGLISH_US->getLanguageName()
                };
        }
    }

    /**
     * @return string The language name (in its native language)
     */
    public function getNativeName(): string
    {
        return match ($this) {
            self::BULGARIAN => "български",
            self::CHINESE_CHINA => "中文",
            self::CHINESE_TAIWAN => "繁體中文",
            self::CROATIAN => "Hrvatski",
            self::CZECH => "Čeština",
            self::DANISH => "Dansk",
            self::DUTCH => "Nederlands",
            self::ENGLISH_UK => "English, UK",
            self::ENGLISH_US => "English, US",
            self::FINNISH => "Suomi",
            self::FRENCH => "Français",
            self::GERMAN => "Deutsch",
            self::GREEK => "Ελληνικά",
            self::HINDI => "हिन्दी",
            self::HUNGARIAN => "Magyar",
            self::INDONESIAN => "Bahasa Indonesia",
            self::ITALIAN => "Italiano",
            self::JAPANESE => "日本語",
            self::KOREAN => "한국어",
            self::LITHUANIAN => "Lietuviškai",
            self::NORWEGIAN => "Norsk",
            self::POLISH => "Polski",
            self::PORTUGUESE_BRAZILIAN => "Português do Brasil",
            self::ROMANIAN_ROMANIA => "Română",
            self::RUSSIAN => "Pусский",
            self::SPANISH => "Español",
            self::SPANISH_LATAM => "Español, LATAM",
            self::SWEDISH => "Svenska",
            self::THAI => "ไทย",
            self::TURKISH => "Türkçe",
            self::UKRAINIAN => "Українська",
            self::VIETNAMESE => "Tiếng Việt",
            self::UNKNOWN => "Unknown",
            default => self::ENGLISH_US->getNativeName()
        };
    }

    /**
     * @return string The respective locale's flag (svg)
     */
    public function getFlag(): string
    {
        return match ($this) {
            self::BULGARIAN => "https://chatbridge.app/assets/icons/flags/bulgaria.svg",
            self::CHINESE_CHINA => "https://chatbridge.app/assets/icons/flags/china.svg",//
            self::CHINESE_TAIWAN => "https://chatbridge.app/assets/icons/flags/taiwan.svg",//
            self::CROATIAN => "https://chatbridge.app/assets/icons/flags/croatia.svg",//
            self::CZECH => "https://chatbridge.app/assets/icons/flags/czech-republic.svg",//
            self::DANISH => "https://chatbridge.app/assets/icons/flags/denmark.svg",//
            self::DUTCH => "https://chatbridge.app/assets/icons/flags/netherlands.svg",//
            self::ENGLISH_UK => "https://chatbridge.app/assets/icons/flags/great-britain.svg",//
            self::ENGLISH_US => "https://chatbridge.app/assets/icons/flags/usa.svg",//
            self::FINNISH => "https://chatbridge.app/assets/icons/flags/finland.svg",//
            self::FRENCH => "https://chatbridge.app/assets/icons/flags/france.svg",//
            self::GERMAN => "https://chatbridge.app/assets/icons/flags/germany.svg",//
            self::GREEK => "https://chatbridge.app/assets/icons/flags/greece.svg",//
            self::HINDI => "https://chatbridge.app/assets/icons/flags/india.svg",//
            self::HUNGARIAN => "https://chatbridge.app/assets/icons/flags/hungary.svg",//
            self::INDONESIAN => "https://chatbridge.app/assets/icons/flags/indonesia.svg",//
            self::ITALIAN => "https://chatbridge.app/assets/icons/flags/italy.svg",//
            self::JAPANESE => "https://chatbridge.app/assets/icons/flags/japan.svg",//
            self::KOREAN => "https://chatbridge.app/assets/icons/flags/south-korea.svg",//
            self::LITHUANIAN => "https://chatbridge.app/assets/icons/flags/lithuania.svg",//
            self::NORWEGIAN => "https://chatbridge.app/assets/icons/flags/norway.svg",//
            self::POLISH => "https://chatbridge.app/assets/icons/flags/poland.svg",//
            self::PORTUGUESE_BRAZILIAN => "https://chatbridge.app/assets/icons/flags/brazil.svg",//
            self::ROMANIAN_ROMANIA => "https://chatbridge.app/assets/icons/flags/romania.svg",//
            self::RUSSIAN => "https://chatbridge.app/assets/icons/flags/russia.svg",//
            self::SPANISH => "https://chatbridge.app/assets/icons/flags/spain.svg",//
            self::SPANISH_LATAM => "https://chatbridge.app/assets/icons/flags/mexico.svg",//
            self::SWEDISH => "https://chatbridge.app/assets/icons/flags/sweden.svg",//
            self::THAI => "https://chatbridge.app/assets/icons/flags/thailand.svg",//
            self::TURKISH => "https://chatbridge.app/assets/icons/flags/turkey.svg",//
            self::UKRAINIAN => "https://chatbridge.app/assets/icons/flags/ukraine.svg",//
            self::VIETNAMESE => "https://chatbridge.app/assets/icons/flags/vietnam.svg",//
            default => ""
        };
    }

    /**
     * Get a {@link Lang} from the `ISO 3166-1` locale
     * @param string $locale The `ISO 3166-1` locale
     * @return Lang The respective {@link Lang}
     */
    public static function fromLocale(string $locale): Lang
    {
        foreach (Lang::cases() as $lang) {
            if ($lang->getLocale() === $locale) {
                return $lang;
            }
        }
        return Lang::UNKNOWN;
    }

    /**
     * Get a {@link Lang} from the Discord-compatible locales
     * @param string $locale The Discord locale
     * @return Lang The respective {@link Lang}
     */
    public static function fromDiscordLocale(string $locale): Lang
    {
        foreach (Lang::cases() as $lang) {
            if ($lang->getDiscordLocale() === $locale) {
                return $lang;
            }
        }
        return Lang::UNKNOWN;
    }
}
