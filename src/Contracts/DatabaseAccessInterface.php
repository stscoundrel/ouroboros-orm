<?php
/**
 * Database Access Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface DatabaseAccessInterface
{
    public function get_prefix() : string;

    public function create_table(string $table, string $columns_sql);

    public function drop_table(string $table);

    public function insert(string $table, array $attributes) : int;

    public function update(string $table, array $attributes, string $primary_key, int $id);

    public function delete(string $table, string $primary_key, int $id);

    public function get_results(string $table, string $column_name, string $column_value);

    public function get_all(string $table);
}
