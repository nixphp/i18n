<?php

namespace NixPHP\I18n\Core;

use NixPHP\I18n\Enum\Language;
use function NixPHP\app;
use function NixPHP\log;

class Translator
{

    private string $lang = Language::EN->value;

    private array $data = [];

    public function translate(string $key, array $params = []): string
    {
        $file = app()->getBasePath() . '/app/Resources/lang/' . $this->lang . '.json';

        if (empty($this->data) && file_exists($file)) {
            $this->data = json_decode(file_get_contents($file), true);
        } else {
            log()->error('Language file not found: ' . $file);
        }

        $result = $this->data[$key] ?? $key;

        foreach ($params as $k => $v) {
            $result = str_replace(':' . $k, $v, $result);
        }

        return $result;
    }

    public function getLanguage(): string
    {
        return $this->lang;
    }

    public function setLanguage(string $lang): void
    {
        $this->lang = $lang;
    }

}