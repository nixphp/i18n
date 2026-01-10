<?php

declare(strict_types=1);

namespace NixPHP\I18n\Support;

use NixPHP\I18n\Core\Language;
use function NixPHP\config;

class LanguageString
{

    public static function normalizeLanguage(string $tag): string
    {
        $tag = trim($tag);

        // "de-DE,de;q=0.9" -> "de-DE"
        if (str_contains($tag, ',')) {
            $tag = explode(',', $tag, 2)[0];
        }

        // Normalize underscores
        $tag = str_replace('_', '-', $tag);

        // "de-DE;q=0.9" -> "de-DE"
        $tag = explode(';', $tag, 2)[0];

        // "de-DE" -> "de"
        $base = strtolower(explode('-', $tag, 2)[0]);

        // VALIDATE: only 2–3 letters (primary language subtag)
        if (!preg_match('/^[a-z]{2,3}$/', $base)) {
            return (string)(config('fallback_language', Language::EN) ?? Language::EN);
        }

        return $base;
    }

}