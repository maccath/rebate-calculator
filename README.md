# 🧮 Rebate Calculator

You have a pre-paid debit card. The card can be topped up, and the money can be spent at retailers offering cashback on any purchases. The rebate is credited to the card in the form of cashback at the end of each month.

This calculator helps determine whether it would be cost-effective to make any given purchase using the pre-paid card.

[![GitHub Workflow](https://img.shields.io/github/actions/workflow/status/maccath/rebate-calculator/php.yml?style=for-the-badge&logo=github&logoColor=white)](https://github.com/maccath/rebate-calculator/actions)
[![PHP](https://img.shields.io/badge/PHP_^7.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)](https://getcomposer.org)

## Requirements
- [PHP ^7.4](https://www.php.net)
- [Composer](https://getcomposer.org)

## Installation

```shell
composer install
```

You may want to add a local configuration file. Create a file named `local.config.php` inside the `config/` directory. 
Configuration options specified in `config/config.php` can be over-written here. By default, Twig caching and debugging are 
disabled.

## Usage

To run the application locally, use the PHP built-in development server.

```shell
php -S localhost:8000
```

The application will be available at [http://localhost:8000](http://localhost:8000/)

## Unit Tests

Tests are written using PHPUnit and stored under app/tests.

```shell
composer test
```
