<?php
/**
 * (table) Schema class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// Contracts.
use Silvanus\Ouroboros\Contracts\TableInterface;

/**
 * --> Define table name
 * --> Define table structure
 */
class Schema implements TableInterface
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
    protected $columns;

    /**
     * Class constructor
     *
     * @param string $table name.
     * @param array $columns key/value list,.
     */
    public function __construct($table, $columns, $primary_key = false)
    {
        global $wpdb;

        // Set table name.
        static::$table = $wpdb->prefix . $table;

        // Set columns.
        foreach ($columns as $name => $type) :
            $this->add_column($name, $type);
        endforeach;

        // Set primary key, if defined.
        static::$primary_key = $primary_key == false ? 'id' : $primary_key;
    }

    /**
     * Get table name with prefix.
     *
     * @return string $table name.
     */
    public static function get_table() : string
    {
        return static::$table;
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
    public function add_column($name, $type)
    {
        $this->columns[$name] = $type;
    }

    /**
     * Return columns array
     *
     * @return array $columns of table;
     */
    public function get_columns()
    {
        return $this->columns;
    }

    /**
     * Return columns as SQL
     *
     * @return string $columns in sql format.
     */
    public function get_columns_sql()
    {
        $columns = '';

        foreach ($this->get_columns() as $name => $type) :
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
     * How WP wants this done:
     * @link https://codex.wordpress.org/Creating_Tables_with_Plugins
     */
    public function create()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Parse SQL from columns.
        $sql = 'CREATE TABLE ' . self::get_table() . ' ( ' . $this->get_columns_sql() . ' ) ' . $charset_collate . ';';

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Execute using WordPress functions.
        dbDelta($sql);
    }

    /**
     * Drop table with all data.
     */
    public function drop()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Parse SQL from columns.
        $sql = 'DROP TABLE  IF EXISTS ' . self::get_table() . ';';

        // Execute using WPDB.
        $wpdb->query($sql);
    }
}
