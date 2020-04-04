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
     * Model attributes
     * key => value array.
     */
    protected $attributes;

    /**
     * Class constructor.
     *
     * @param array $attributes of model.
     */
    public function __construct( $attributes = array() ) {
        if( ! empty( $attributes ) ) :
            foreach ($attributes as $key => $value) :
                $this->set( $key, $value );
            endforeach;
        endif;
    }

    private function get_table() {
        global $wpdb;

        return $wpdb->prefix . $this->table;
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
     * Creates new record in DB.
     */
    public function create() {
        global $wpdb;

        $wpdb->insert( $this->get_table(), $this->attributes );     
    }
}
