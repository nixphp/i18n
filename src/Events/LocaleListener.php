<?php

declare(strict_types=1);

namespace NixPHP\I18n\Events;

use NixPHP\I18n\Core\Translator;
use Psr\Http\Message\ServerRequestInterface;
use function NixPHP\app;

class LocaleListener
{
    public function handle(ServerRequestInterface $request): void
    {
        if (str_contains((string)$request->getUri(), '/favicon.ico')) {
            return;
        }

        $queryLang   = $request->getQueryParams()['lang'] ?? null;
        $cookieLang  = $request->getCookieParams()['lang'] ?? null;
        $headerLang  = $this->parseAcceptLanguage($request->getHeaderLine('Accept-Language'));

        $language = $queryLang ?? $cookieLang ?? $headerLang[0] ?? null;

        if ($language === null) {
            return;
        }

        $translator = app()->container()->get(Translator::class);

        $translator->setLanguage($language);
    }

    private function parseAcceptLanguage(string $header): array
    {
        $languages = [];
        $parts     = explode(',', $header);

        foreach ($parts as $part) {
            $segments = explode(';', trim($part));
            $locale = strtolower(trim($segments[0]));
            $quality = 1.0;

            if (isset($segments[1]) && str_starts_with($segments[1], 'q=')) {
                $quality = (float) substr($segments[1], 2);
            }

            $languages[$locale] = $quality;
        }

        arsort($languages, SORT_NUMERIC);

        return array_keys($languages);
    }

}