<?php

declare(strict_types=1);

namespace NixPHP\I18n\Events;

use NixPHP\I18n\Core\Translator;
use Psr\Http\Message\ResponseInterface;
use function NixPHP\app;
use function NixPHP\log;
use function NixPHP\request;

class CookieSetListener
{

    public function handle(ResponseInterface $response):? ResponseInterface
    {
        /** @var Translator $translator */
        $translator = app()->container()->get('translator');
        $lang = $translator->getLanguage();

        $queryLang = request()->getQueryParams()['lang'] ?? null;
        $cookieLang = request()->getCookieParams()['lang'] ?? null;

        if ($queryLang || !$cookieLang || !$lang) {
            log()->info('Setting cookie lang: ' . $lang);
            return $response->withAddedHeader(
                'Set-Cookie',
                sprintf('lang=%s; Path=/; Max-Age=%d; SameSite=Lax', $lang, 60 * 60 * 24 * 30)
            );
        }

        return null;
    }

}