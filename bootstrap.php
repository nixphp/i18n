<?php

declare(strict_types=1);

use NixPHP\I18n\Core\Translator;
use NixPHP\I18n\Events\CookieSetListener;
use NixPHP\I18n\Events\LocaleListener;
use NixPHP\Enum\Event;
use function NixPHP\app;
use function NixPHP\event;

app()->container()->set(Translator::class, fn() => new Translator());

event()->listen(Event::REQUEST_START, [LocaleListener::class, 'handle']);
event()->listen(Event::RESPONSE_HEADER, [CookieSetListener::class, 'handle']);
