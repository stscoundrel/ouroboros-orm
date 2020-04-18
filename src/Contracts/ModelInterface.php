<?php
/**
 * Model Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface ModelInterface
{

    public function get($key);

    public function set($key, $value);

    public static function find($id);

    public static function where($column_name, $column_value);

    public function create($attributes);

    public function update($attributes);

    public function delete($id);

    public function all();
}
