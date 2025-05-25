<div style="text-align: center;" align="center">

![Logo](https://nixphp.github.io/docs/assets/nixphp-logo-small-square.png)

[![NixPHP I18n Plugin](https://github.com/nixphp/i18n/actions/workflows/php.yml/badge.svg)](https://github.com/nixphp/i18n/actions/workflows/php.yml)

</div>

[← Back to NixPHP](https://github.com/nixphp/framework)

---

# nixphp/i18n

> **Simple JSON-based translations for your NixPHP application.**

This plugin provides a lightweight translation system for multilingual apps.
It reads language files from disk, supports variable replacements, and falls back gracefully — all with minimal overhead.

> 🧩 Part of the official NixPHP plugin collection.
> Install it if you want clean, flexible localization without external libraries.

---

## 📦 Features

* ✅ Loads language files from `app/Resources/lang/`
* ✅ Supports `translator()->get('key')` with fallback mechanism
* ✅ Replaces variables via `:name`, `:count`, etc.
* ✅ Language codes follow ISO 639-1 (e.g. `en`, `de`, `fr`)
* ✅ JSON-based – easy to edit, export and manage

---

## 📥 Installation

```bash
composer require nixphp/i18n
```

The plugin auto-registers and makes a `translator()` helper available globally.

---

## 🚀 Usage

### 🔍 Get a translation

```php
echo translator()->get('welcome');
```

Assuming `app/Resources/lang/en.json` contains:

```json
{
  "welcome": "Welcome to our site!"
}
```

You’ll see:
`Welcome to our site!`

---

### ✨ With replacements

```php
echo translator()->get('greeting', ['name' => 'Flo']);
```

With this JSON entry:

```json
{
  "greeting": "Hello, :name!"
}
```

Result:
`Hello, Flo!`

---

### 🌍 Switch language

```php
translator()->setLocale('de');
```

Make sure `app/Resources/lang/de.json` exists.

---

### 🔄 Fallback

If a key is missing, the key itself is returned:

```php
translator()->get('unknown_key');
// → "unknown_key"
```

This helps you spot missing translations during development.

---

## 📁 File structure

```
app/
└── Resources/
    └── lang/
        ├── en.json
        ├── de.json
        └── fr.json
```

Each file should be a flat key-value map using UTF-8 encoded JSON.

---

## ✅ Requirements

* `nixphp/framework` >= 1.0
* PHP >= 8.1

---

## 📄 License

MIT License.