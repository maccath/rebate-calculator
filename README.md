# rebate-calculator
A rebate calculator for a pre-paid card service.

## Purpose

My company offers a pre-paid debit card benefit. The card can be topped up, and the money can be spent at a variety of
participating retailers, most of whom offer a percentage rebate on any purchases made with the card. The rebate is credited to the card in the form of cashback at the end of each month.

This calculator helps determine whether it would be cost-effective to make any given purchase using the pre-paid debit card.

## Installation

Dependencies are managed with Composer. After cloning the repository, run `composer install` from terminal to automatically
install dependencies.

You may want to add a local configuration file. Create a file named `local.config.php` inside the `config/` directory. 
Configuration options specified in `config/config.php` can be over-written here. By default, Twig caching and debugging are 
disabled.

## Usage

Run `index.php` in the browser. This should present a form, which upon being submitted, will take you to a results page.
