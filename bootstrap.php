<?php

use NixPHP\I18n\Core\Translator;
use NixPHP\I18n\Events\CookieSetListener;
use NixPHP\I18n\Events\LocaleListener;
use function NixPHP\app;
use function NixPHP\event;

app()->container()->set('translator', function() {
    return new Translator();
});

event()->listen('request.start', [LocaleListener::class, 'handle']);
event()->listen('response.header', [CookieSetListener::class, 'handle']);
