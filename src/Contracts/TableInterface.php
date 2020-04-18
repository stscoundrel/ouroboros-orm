<?php
/**
 * Table Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface TableInterface
{

    public static function get_table() : string;

    public static function set_table(string $table);
    
    public static function get_primary_key() : string;
    
    public static function set_primary_key(string $primary_key);
}
