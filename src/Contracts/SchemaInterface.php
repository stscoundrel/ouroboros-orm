<?php
/**
 * Schema Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface SchemaInterface
{

    public function add_column(string $name, string $type);

    public function get_column(string $name) : string;

    public function get_columns() : array;

    public function create();

    public function drop();
}
