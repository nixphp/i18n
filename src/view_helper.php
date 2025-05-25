<?php

namespace NixPHP\I18n;

use function NixPHP\app;

function t(string $key): string
{
    return app()->container()->get('translator')->translate($key);
}