<?php
/**
 * Model Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface ModelInterface
{

    public function get(string $key);

    public function set(string $key, $value);

    public static function find(int $id) : ModelInterface;

    public static function where(string $column_name, string $column_value) : array;

    public static function create(array $attributes) : int;

    public static function update(array $attributes);

    public static function delete(int $id);

    public function save();

    public static function all() : array;

    public function get_attributes() : array;
}
