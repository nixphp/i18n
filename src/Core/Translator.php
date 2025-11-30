<?php

declare(strict_types=1);

namespace NixPHP\I18n\Core;

use function NixPHP\app;
use function NixPHP\config;
use function NixPHP\log;

class Translator
{
    private ?string $language;
    private array $data = [];

    public function __construct(?string $language = null)
    {
        $this->language = $language;
        $this->reload();
    }

    public function reload(): void
    {
        $this->loadLanguageData();
    }

    public function translate(string $key, array $params = []): string
    {
        $result = $this->data[$key] ?? $key;

        foreach ($params as $k => $v) {
            $result = str_replace(':' . $k, $v, $result);
        }

        return $result;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $lang): void
    {
        $this->language = $lang;
        $this->reload();
    }

    private function loadLanguageData(): void
    {
        $lang     = $this->language ?? config('language') ?? config('fallback_language', Language::EN);
        $filePath = app()->getBasePath() . config('app:translationPath', '/app/Resources/lang');
        $file     = sprintf('%s/%s.json', $filePath, $lang);

        if (!file_exists($file)) {
            log()->error('Language file not found: ' . $file);
            throw new \LogicException('Language file not found: ' . $file);
        }

        $data = json_decode(file_get_contents($file), true);

        if (!is_array($data)) {
            log()->error('Invalid or malformed JSON in language file: ' . $file);
            throw new \LogicException('Invalid JSON in language file: ' . $file);
        }

        $this->language = $lang;
        $this->data     = $data;
    }

}