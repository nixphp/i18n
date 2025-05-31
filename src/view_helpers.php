<?php

namespace NixPHP\I18n;

use function NixPHP\app;

function t(string $key, array $params = []): string
{
    return app()->container()->get('translator')->translate($key, $params);
}