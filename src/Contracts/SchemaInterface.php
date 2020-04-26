<?php
/**
 * Schema Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface SchemaInterface
{

    public static function add_column(string $name, string $type);

    public static function get_column(string $name) : string;

    public static function get_columns() : array;

    public static function create();

    public static function drop();
}
