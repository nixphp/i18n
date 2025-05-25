<?php

namespace Tests\Unit;

use NixPHP\Core\Config;
use NixPHP\I18n\Core\Translator;
use Tests\NixPHPTestCase;
use function NixPHP\app;
use function NixPHP\I18n\t;

class TranslatorTest extends NixPHPTestCase
{

    public function testTranslationSuccess()
    {
        $translator = new Translator();
        $this->assertSame('translated', $translator->translate('translated'));
    }

    public function testTranslationMissingReturnsKey()
    {
        $translator = new Translator();
        $this->assertSame('does-not-exist', $translator->translate('does-not-exist'));
    }

    public function testTranslationWithDifferentLanguage()
    {
        $config = new Config(['locale' => 'de', 'fallback_locale' => 'en']);
        app()->container()->set('config', $config);
        $translator = new Translator();
        $this->assertSame('übersetzt', $translator->translate('translated'));
    }

    public function testTranslationFallbackLanguage()
    {
        $config = new Config(['locale' => 'es', 'fallback_locale' => 'en']);
        app()->container()->set('config', $config);
        $translator = new Translator();
        $this->assertSame('translated', $translator->translate('translated'));
    }

    public function testTranslationMissingLanguageFile()
    {
        $this->expectException(\LogicException::class);
        $config = new Config(['locale' => 'xx']);
        app()->container()->set('config', $config);
        $translator = new Translator();
        $translator->translate('translated');
    }

    public function testTranslationWithParams()
    {
        $config = new Config(['locale' => 'de']);
        app()->container()->set('config', $config);
        $translator = new Translator();
        $this->assertSame('test output', $translator->translate('parameter', ['testKey' => 'output']));
    }

    public function testTranslationWithParamsAndMissingKey()
    {
        $config = new Config(['locale' => 'de']);
        app()->container()->set('config', $config);
        $translator = new Translator();
        $this->assertSame('test :testKey', $translator->translate('parameter', ['does-not-exist' => '']));
    }

    public function testHelperFunction()
    {
        $config = new Config(['locale' => 'en']);
        app()->container()->set('config', $config);
        $this->assertSame('translated', t('translated'));
    }

}