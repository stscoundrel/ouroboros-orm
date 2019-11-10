<?php
/**
 * (table) Schema class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

use \Silvanus\Ouroboros\Schema\TypesInterface;

/**
 * --> Define table name
 * --> Define table structure
 */
class Schema implements TypesInterface
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
     * @param array $columns key/value list,.
     */
    public function __construct($table, $columns)
    {
        global $wpdb;

        $this->table = $wpdb->prefix . $table;

        foreach ($columns as $name => $type) :
            $this->add_column($name, $type);
        endforeach;
    }

    /**
     * Add column to table
     *
     * @param string $name of column.
     * @param string $type of column.
     */
    public function add_column($name, $type)
    {
        // Maybe format Type
        if (is_array($type)) :
            // Format text types
            if (in_array($type[0], self::CHAR_TYPES)) :
                $type = $type[0] . '(' . $type[1] . ')';
            endif;
        endif;

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
