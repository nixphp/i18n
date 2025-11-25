<?php

declare(strict_types=1);

namespace NixPHP\I18n;

use NixPHP\I18n\Core\Translator;
use NixPHP\I18n\Enum\Language;
use function NixPHP\app;

/**
 * @param string     $key
 * @param array|null $params
 *
 * @return string
 */
function t(string $key, ?array $params = []): string
{
    return app()->container()->get(Translator::class)->translate($key, $params);
}

/**
 * @return Translator
 */
function translator(): Translator
{
    return app()->container()->get(Translator::class);
}

/**
 * @return Language
 */
function lang(): Language
{
    return app()->container()->get(Translator::class)->getLanguage();
}