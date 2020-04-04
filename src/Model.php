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
    protected $table;

    /**
     * Primary key of table.
     * Default: id.
     * Used to fetch records by id.
     */
    protected $primary_key = 'id';

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
    private function get_table() {
        global $wpdb;

        return $wpdb->prefix . $this->table;
    }

    /**
     * Retun primary key.
     *
     * @return string $primary_key of table.
     */
    private function get_primary_key() {
        return $this->primary_key;
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
     *
     * @param int $id of record.
     */
    public function update() {
        global $wpdb;

        $wpdb->update(
            $this->get_table(),
            $this->attributes,
            array( 'id' => $this->id ),
        );     
    }
}
