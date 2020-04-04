<?php
/**
 * Model class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

/**
 * --> Models custom DB table
 * --> Common data manipulation meethods.
 */
class Model
{   
    /**
     * Table name in database.
     */
    protected static $table;

    /**
     * Primary key of table.
     * Default: id.
     * Used to fetch records by id.
     */
    protected static  $primary_key = 'id';

    /**
     * Model attributes
     * key => value array.
     */
    protected $attributes;

    /**
     * ID of fetched record.
     */
    public $id;

    /**
     * Class constructor.
     *
     * @param int $id of record in DB.
     */
    public function __construct( $id = null ) {
        $this->id = $id;      
    }

    /**
     * Get table name with prefix.
     *
     * @return string $table name.
     */
    private static function get_table() {
        global $wpdb;

        return $wpdb->prefix . static::$table;
    }

    /**
     * Retun primary key.
     *
     * @return string $primary_key of table.
     */
    private static function get_primary_key() {
        return self::$primary_key;
    }

    /**
     * Set model attribute.
     *
     * @param string $key of attribute.
     * @param mixed $value of attribute.
     */
    public function set( $key, $value ) {
        $this->attributes[ $key ] = $value;
    }

    /**
     * Unset model attribute.
     *
     * @param string $key of attribute.
     */
    public function unset( $key ) {
       unset( $this->attributes[ $key ] ) ;
    }

    /**
     * Creates new record in DB.
     */
    public function create() {
        global $wpdb;

        $wpdb->insert( $this->get_table(), $this->attributes );     
    }

    /**
     * Updates record in DB.
     */
    public function update() {
        global $wpdb;

        $wpdb->update(
            $this->get_table(),
            $this->attributes,
            array( $this->get_primary_key() => $this->id ),
        );     
    }

    /**
     * Delete record from DB.
     */
    public function delete() {
        global $wpdb;

        $wpdb->delete(
            $this->get_table(),
            array( $this->get_primary_key() => $this->id ),
        );     
    }

    /**
     * Find record from DB.
     *
     * @param int $id of record.
     * @return array $record by id.
     */
    public static function find( $id ) {
        global $wpdb;

        $table       = self::get_table();
        $primary_key = self::get_primary_key();

        $record = $wpdb->get_row( "SELECT * FROM $table WHERE $primary_key = $id", ARRAY_A );

        return $record;
    }
}
