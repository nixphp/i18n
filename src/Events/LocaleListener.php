<?php

namespace NixPHP\I18n\Events;

use NixPHP\I18n\Core\Translator;
use Psr\Http\Message\ServerRequestInterface;
use function NixPHP\app;
use function NixPHP\config;

class LocaleListener
{
    public function handle(ServerRequestInterface $request): void
    {
        if (str_contains($request->getUri(), '/favicon.ico')) {
            return;
        }

        $headerLang  = $this->parseAcceptLanguage($request->getHeaderLine('Accept-Language'));
        $queryLang   = $request->getQueryParams()['lang'] ?? null;
        $cookieLang  = $request->getCookieParams()['lang'] ?? null;

        $language = $queryLang
            ?? $cookieLang
            ?? $headerLang[0]
            ?? config('fallback_locale');

        /** @var Translator $translator */
        $translator = app()->container()->get('translator');

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