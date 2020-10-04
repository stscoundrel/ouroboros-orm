<?php
/**
 * (table) Schema class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// DB access.
use Silvanus\Ouroboros\DatabaseAccess;

// Contracts.
use Silvanus\Ouroboros\Contracts\SchemaInterface;
use Silvanus\Ouroboros\Contracts\TableInterface;

// Exceptions.
use Silvanus\Ouroboros\Exceptions\NoTableSetException;

/**
 * --> Define table name
 * --> Define table structure
 */
class Schema implements SchemaInterface, TableInterface
{

    /**
     * Table name
     *
     * @var string
     */
    protected static $table;

    /**
     * Primary key
     * If not set, defaults to 'id'
     *
     * @var string
     */
    protected static $primary_key;

    /**
     * Table columns
     *
     * @var array
     */
    protected static $columns;

    /**
     * Class constructor
     *
     * @param string $table name.
     * @param array $columns key/value list,.
     */
    public function __construct($table = null, $columns = null, $primary_key = false)
    {

        if ($table) :
            // Set table name.
            static::$table = self::set_table($table);
        endif;

        if ($columns) :
            // Set columns.
            foreach ($columns as $name => $type) :
                self::add_column($name, $type);
            endforeach;
        endif;

        // Set primary key, if defined.
        static::$primary_key = $primary_key == false ? 'id' : $primary_key;
    }

    /**
     * Get table name
     *
     * @return string $table name.
     */
    public static function get_table() : string
    {
        if (! static::$table) :
            throw new NoTableSetException();
        endif;
        
        return static::$table;
    }

    /**
     * Get table name with prefix.
     *
     * @return string $table name.
     */
    public static function get_table_with_prefix() : string
    {
        return DatabaseAccess::get_prefix() . static::get_table();
    }

    /**
     * set table name
     *
     * @param string $table name.
     */
    public static function set_table(string $table)
    {
        static::$table = $table;
    }

    /**
     * Retun primary key.
     *
     * @return string $primary_key of table.
     */
    public static function get_primary_key() : string
    {
        if( ! static::$primary_key ) :
            return 'id';
        endif;
        
        return static::$primary_key;
    }

    /**
     * Set primary key.
     *
     * @param string $primary_key of table.
     */
    public static function set_primary_key(string $primary_key)
    {
        static::$primary_key = $primary_key;
    }

    /**
     * Add column to table
     *
     * @param string $name of column.
     * @param string $type of column.
     */
    public static function add_column(string $name, string $type)
    {
        static::$columns[$name] = $type;
    }

    /**
     * Get column from columns
     *
     * @param string $name of column.
     * @return string $type of column.
     */
    public static function get_column(string $name) : string
    {
        return static::$columns[$name];
    }

    /**
     * Return columns array
     *
     * @return array $columns of table;
     */
    public static function get_columns() : array
    {
        return static::$columns;
    }

    /**
     * Return columns as SQL
     *
     * @return string $columns in sql format.
     */
    public static function get_columns_sql()
    {
        $columns = '';

        foreach (self::get_columns() as $name => $type) :
            $columns .= $name . ' ' . $type . ', ';
        endforeach;

        // Append created_at column.
        $columns .= 'created_at DATETIME DEFAULT CURRENT_TIMESTAMP, ';
        $columns .= 'updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP, ';

        // Append primary key definition.
        $columns .= 'PRIMARY KEY (' . self::get_primary_key() . ')';

        return $columns;
    }

    /**
     * Save table to database.     
     */
    public static function create()
    {
        DatabaseAccess::create_table(self::get_table_with_prefix(), self::get_columns_sql());
    }

    /**
     * Drop table with all data.
     */
    public static function drop()
    {
        DatabaseAccess::drop_table(self::get_table_with_prefix());
    }
}
