<?php

namespace NixPHP\I18n\Core;

use NixPHP\I18n\Enum\Language;
use function NixPHP\app;
use function NixPHP\config;

class Translator
{

    private string $lang;

    public function __construct()
    {
        $this->lang = config('locale', config('fallback_locale')) ?? Language::EN->value;
    }

    public function translate(string $key, array $params = []): string
    {
        $file = app()->getBasePath() . '/app/Resources/lang/' . $this->lang . '.json';
        if (!file_exists($file)) {
            throw new \LogicException('Language file "' . $file . '" not found.');
        }
        $data = json_decode(file_get_contents($file), true);

        $result = $data[$key] ?? $key;

        foreach ($params as $k => $v) {
            $result = str_replace(':' . $k, $v, $result);
        }

        return $result;
    }

}