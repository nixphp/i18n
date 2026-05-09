<?php

declare(strict_types=1);

namespace Tests;

use NixPHP\Core\Config;
use NixPHP\I18n\Core\Translator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use function NixPHP\app;

class NixPHPTestCase extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        app()->container()->set(Config::class, new Config([
            'language' => 'en',
            'fallback_language' => 'en',
        ]));
        app()->container()->set(Translator::class, fn() => new Translator());
        app()->container()->reset(RequestInterface::class);
    }
}
