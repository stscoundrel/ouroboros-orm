<?php
/**
 * (table) Schema class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

/**
 * --> Define table name
 * --> Define table structure
 */
class Schema
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table;

    /**
     * Table columns
     *
     * @var array
     */
    protected $columns;

    /**
     * Class constructor
     *
     * @param string $table name.
     */
    public function __construct($table)
    {
        global $wpdb;

        $this->table = $wpdb->prefix . $table;
    }

    /**
     * Add column to table
     *
     * @param string $name of column.
     * @param string $type of column.
     */
    public function add_column($name, $type)
    {
        $this->columns[$name] = $type;
    }

    /**
     * Save table to database.
     */
    public function create()
    {
    }

    /**
     * Drop table with all data.
     */
    public function drop()
    {
    }
}
