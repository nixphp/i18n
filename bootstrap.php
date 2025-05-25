<?php

use NixPHP\I18n\Core\Translator;
use function NixPHP\app;

app()->container()->set('translator', function() {
    return new Translator();
});

