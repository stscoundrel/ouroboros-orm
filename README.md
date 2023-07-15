## Status

Ouroboros was originally written when I still worked more with PHP / WP. The basic functionalities were finished and worked, but never really finalized or tested in a real project.

There is a good chance it all works, so feel free to look around or fork it. Still, be warned: do not use for purposes other than curiosity.

# Ouroboros ORM

Create and use custom WP database tables in ORM-like way. Inspired by tools like Eloquent ORM and Objection.js.

## Features

- Schemas: create custom tables for your data.
- Migrations: run your schemas up / down with CLI commands.
- Models: create and use data with model entitites.
- REST API: easily use your Ouroboros data from WP REST endpoints.

## Motivation

WP database structure is less-than-optimal. When you find yourself creating custom tables in WordPress, you should probably consider using some other platform.

However, we can't always decide what tools we use for a project. The way WordPress supports creating new tables or using data in them is very bare bones. Ouroboros aims to make working with custom tables more streamlined and enjoyable.

## Usage

- See "examples" folder
- See "tests" and "src" to get general idea.

## Install

Via Composer:

`composer require silvanus/ouroboros-orm`

To use autoloading mechanism, you must include `vendor/autoload.php` file in your code.

## Whats in the name?

For those who speak north germanic languages, "orm" means snake or a worm. Therefore I've always associated "ORM" systems with snakes. ["Ouroboros"](https://en.wikipedia.org/wiki/Ouroboros) is a snake biting it's own tail, which is fitting enough description for writing an ORM for WordPress.
