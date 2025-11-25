<?php

declare(strict_types=1);

namespace NixPHP\I18n\Enum;

/**
 * Enum Language
 *
 * Represents supported languages using ISO 639-1 codes.
 * Extend this enum as needed to support more locales.
 */
enum Language: string
{
    case EN = 'en';     // English
    case DE = 'de';     // German
    case FR = 'fr';     // French
    case ES = 'es';     // Spanish
    case IT = 'it';     // Italian
    case PT = 'pt';     // Portuguese
    case RU = 'ru';     // Russian
    case ZH = 'zh';     // Chinese (Mandarin)
    case JA = 'ja';     // Japanese
    case KO = 'ko';     // Korean
    case AR = 'ar';     // Arabic
    case HI = 'hi';     // Hindi
    case TR = 'tr';     // Turkish
    case PL = 'pl';     // Polish
    case NL = 'nl';     // Dutch
    case SV = 'sv';     // Swedish
    case CS = 'cs';     // Czech
    case RO = 'ro';     // Romanian
    case HU = 'hu';     // Hungarian
    case FA = 'fa';     // Persian (Farsi)
    case HE = 'he';     // Hebrew
    case UK = 'uk';     // Ukrainian
    case TH = 'th';     // Thai
    case VI = 'vi';     // Vietnamese

    /**
     * Returns the localized label for each language.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
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
        return array_map(fn($lang) => $lang->value, self::cases());
    }
}
