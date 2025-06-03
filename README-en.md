# ScpoPHP

[简体中文](README.md) | **English**

ScpoPHP is a function library developed by China entertainment club Scpos now.

Beacuse ScpoPHP is the library Scpos used, it's mainly developed in Chinese.

## All the Module

The modules marked with "*" have not been developed completely.

- Api: API related
- Cache: Web cache related
- Cookie: Cookie operation related
- Db: SQL Database CRUD related
- Email: Some useful mailing functions based on PHPMailer
- Errpage: HTTP error code related
- Str: Functions that can convert string, bin and hex to each other
- Url: URL rewrite related
- *User: User system related

## Useage

1. Clone the repositories to the local through `git submodule add https://github.com/n9gc/php.git scpo-php`
2. Copy `scpo-php/config.default.php` and rename it to `config.php`
3. Change the congigures in `config.php`
4. Add the sentence `require 'scpos.php'` to your project
5. Use the functions like `ScpoPHP\Module::method()` and enjoy!
