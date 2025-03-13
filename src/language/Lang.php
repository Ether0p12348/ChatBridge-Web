<?php

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
            default => self::ENGLISH_US->getLocale()()
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
     * Get a {@link Lang} from the `ISO 3166-1` locale
     * @param string $locale The `ISO 3166-1` locale
     * @return Lang The respective {@link Lang}
     */
    public function fromLocale(string $locale): Lang
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
    public function fromDiscordLocale(string $locale): Lang
    {
        foreach (Lang::cases() as $lang) {
            if ($lang->getDiscordLocale() === $locale) {
                return $lang;
            }
        }
        return Lang::UNKNOWN;
    }
}
