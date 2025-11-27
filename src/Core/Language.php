<?php

declare(strict_types=1);

namespace NixPHP\I18n\Core;

/**
 * Enum Language
 *
 * Represents supported languages using ISO 639-1 codes.
 * Extend this enum as needed to support more locales.
 */
class Language
{
    private static array $cache = [];

    const string EN = 'en';     // English
    const string DE = 'de';     // German
    const string FR = 'fr';     // French
    const string ES = 'es';     // Spanish
    const string IT = 'it';     // Italian
    const string PT = 'pt';     // Portuguese
    const string RU = 'ru';     // Russian
    const string ZH = 'zh';     // Chinese (Mandarin)
    const string JA = 'ja';     // Japanese
    const string KO = 'ko';     // Korean
    const string AR = 'ar';     // Arabic
    const string HI = 'hi';     // Hindi
    const string TR = 'tr';     // Turkish
    const string PL = 'pl';     // Polish
    const string NL = 'nl';     // Dutch
    const string SV = 'sv';     // Swedish
    const string CS = 'cs';     // Czech
    const string RO = 'ro';     // Romanian
    const string HU = 'hu';     // Hungarian
    const string FA = 'fa';     // Persian (Farsi)
    const string HE = 'he';     // Hebrew
    const string UK = 'uk';     // Ukrainian
    const string TH = 'th';     // Thai
    const string VI = 'vi';     // Vietnamese

    /**
     * Returns the localized label for each language.
     *
     * @param string $language
     *
     * @return string
     */
    public function label(string $language): string
    {
        return match ($language) {
            self::EN => 'English',
            self::DE => 'Deutsch',
            self::FR => 'Français',
            self::ES => 'Español',
            self::IT => 'Italiano',
            self::PT => 'Português',
            self::RU => 'Русский',
            self::ZH => '中文',
            self::JA => '日本語',
            self::KO => '한국어',
            self::AR => 'العربية',
            self::HI => 'हिन्दी',
            self::TR => 'Türkçe',
            self::PL => 'Polski',
            self::NL => 'Nederlands',
            self::SV => 'Svenska',
            self::CS => 'Čeština',
            self::RO => 'Română',
            self::HU => 'Magyar',
            self::FA => 'فارسی',
            self::HE => 'עברית',
            self::UK => 'Українська',
            self::TH => 'ไทย',
            self::VI => 'Tiếng Việt',
        };
    }

    /**
     * Returns an array of all language codes.
     *
     * Useful for generating dropdowns or validation rules.
     *
     * @return string[]
     */
    public static function all(): array
    {
        $class = static::class;

        if (isset(self::$cache[$class])) {
            return self::$cache[$class];
        }

        $ref = new \ReflectionClass($class);
        return self::$cache[$class] = $ref->getConstants();
    }
}
