<?php

declare(strict_types=1);

namespace NixPHP\I18n\Events;

use NixPHP\I18n\Core\Translator;
use Psr\Http\Message\ServerRequestInterface;
use function NixPHP\app;

class LocaleListener
{

    /**
     * Handles locale detection and sets the application language based on request data.
     *
     * Determines the user's preferred language by checking query parameters, cookies,
     * and the Accept-Language header in that order. The detected language is normalized
     * and set in the application's Translator instance. Requests to favicon.ico are ignored.
     *
     * @param ServerRequestInterface $request The incoming HTTP request containing locale information.
     *
     * @return void
     */
    public function handle(ServerRequestInterface $request): void
    {
        if (str_contains((string)$request->getUri(), '/favicon.ico')) {
            return;
        }

        $queryLang   = $request->getQueryParams()['lang'] ?? null;
        $cookieLang  = $request->getCookieParams()['lang'] ?? null;
        $headerLang  = $this->parseAcceptLanguage($request->getHeaderLine('Accept-Language'));
        $language    = $queryLang ?? $cookieLang ?? $headerLang[0] ?? null;

        if (null === $language) {
            return;
        }

        $language = $this->normalizeLanguage($language);
        app()->container()->get(Translator::class)->setLanguage($language);
    }

    /**
     * Parses the `Accept-Language` HTTP header and extracts a list of locales ranked by quality values.
     *
     * @param string $header The raw `Accept-Language` header value.
     *
     * @return array An ordered list of locale strings, sorted by their quality values in descending order.
     */
    private function parseAcceptLanguage(string $header): array
    {
        $languages = [];

        foreach (explode(',', $header) as $part) {
            $segments = array_map('trim', explode(';', trim($part)));
            $locale   = strtolower(str_replace('_', '-', $segments[0]));
            $quality  = 1.0;

            foreach (array_slice($segments, 1) as $seg) {
                if (str_starts_with($seg, 'q=')) {
                    $quality = (float) substr($seg, 2);
                }
            }

            $languages[$locale] = $quality;
        }

        arsort($languages, SORT_NUMERIC);

        return array_keys($languages);
    }

    /**
     * Normalizes a language tag by extracting the basic language component and converting it to lowercase.
     *
     * @param string $tag The raw language tag, which may include region subtags, quality values, or multiple entries.
     *
     * @return string The normalized basic language tag in lowercase format.
     */
    private function normalizeLanguage(string $tag): string
    {
        $tag = trim($tag);

        // String transformed from "de-DE,de;q=0.9" to "de-DE"
        if (str_contains($tag, ',')) {
            $tag = explode(',', $tag, 2)[0];
        }

        // Normalize underscores
        $tag = str_replace('_', '-', $tag);

        // Cut quality part (in case something like "de-DE;q=0.9" comes in)
        $tag = explode(';', $tag, 2)[0];

        // Only basic language
        $base = explode('-', $tag, 2)[0];

        return strtolower($base);
    }

}