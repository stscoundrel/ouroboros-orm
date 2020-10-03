<?php
/**
 * Database Access Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface DatabaseAccessInterface
{
    public static function get_prefix() : string;

    public static function create_table(string $table, string $columns_sql);

    public static function drop_table(string $table);

    public static function insert(string $table, array $attributes) : int;

    public static function update(string $table, array $attributes, string $primary_key, int $id);

    public static function delete(string $table, string $primary_key, int $id);

    public static function get_results(string $table, string $column_name, string $column_value);

    public static function get_all(string $table);
}
