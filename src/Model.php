<?php
/**
 * Model class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// Contracts.
use Silvanus\Ouroboros\Contracts\ModelInterface;
use Silvanus\Ouroboros\Contracts\TableInterface;

use \Exception;

/**
 * --> Models custom DB table
 * --> Common data manipulation meethods.
 */
class Model implements ModelInterface, TableInterface
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
    protected static $primary_key = 'id';

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
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Get table name with prefix.
     *
     * @return string $table name.
     */
    public static function get_table() : string
    {
        global $wpdb;

        return $wpdb->prefix . static::$table;
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
     * Retun attributes
     *
     * @return array $attributes of instance.
     */
    protected function get_attributes()
    {
        return $this->attributes;
    }

    /**
     * Get model attribute.
     *
     * @param string $key of attribute.
     * @return mixed $value of attribute.
     */
    public function get(string $key)
    {
        return $this->attributes[ $key ];
    }

    /**
     * Set model attribute.
     *
     * @param string $key of attribute.
     * @param mixed $value of attribute.
     */
    public function set(string $key, $value)
    {
        $this->attributes[ $key ] = $value;
    }

    /**
     * Unset model attribute.
     *
     * @param string $key of attribute.
     */
    public function unset(string $key)
    {
        unset($this->attributes[ $key ]) ;
    }

    /**
     * Creates new record in DB.
     *
     * @param array $attributes to create, optional.
     */
    public static function create(array $attributes = array()) : int
    {
        global $wpdb;

        $wpdb->insert(self::get_table(), $attributes);

        return $wpdb->insert_id;
    }

    /**
     * Updates record in DB.
     *
     * @param array $attributes to update, optional.
     */
    public static function update(array $attributes = array())
    {
        global $wpdb;

        if (array_key_exists(self::get_primary_key(), $attributes)) :
            $id = $attributes[ self::get_primary_key() ];
        else :
            throw new Exception('ID not provided in arguments, can not update.');
        endif;

        $wpdb->update(
            self::get_table(),
            $attributes,
            array( self::get_primary_key() => $id ),
        );
    }

    /**
     * Delete record from DB.
     *
     * @param int $id of record in DB.
     */
    public static function delete(int $id)
    {
        global $wpdb;

        $wpdb->delete(
            self::get_table(),
            array( self::get_primary_key() => $id ),
        );
    }

    /**
     * Find record from DB by id.
     *
     * @param int $id of record.
     * @return Model $record by id.
     */
    public static function find(int $id) : ModelInterface
    {
        global $wpdb;

        $id = sanitize_text_field($id);

        $primary_key = self::get_primary_key();

        $record = self::where($primary_key, $id);

        if (count($record) === 1) :
            $record = $record[0];
        endif;

        return $record;
    }

    /**
     * Find record from DB by key & value pair.
     *
     * @param string $column_name in table.
     * @param string $column_value in table.
     * @return Model $record by id.
     */
    public static function where(string $column_name, string $column_value) : array
    {
        global $wpdb;

        $column_name = sanitize_text_field($column_name);
        $column_value = sanitize_text_field($column_value);

        $table       = self::get_table();
        $primary_key = self::get_primary_key();

        if (! is_numeric($column_name)) :
            $column_value = "'$column_value'";
        endif;

        $results = $wpdb->get_results("SELECT * FROM $table WHERE $column_name = $column_value", ARRAY_A);

        $records = self::instances_from_array( $results );        

        return $records;
    }

    /**
     * Get all records from DB.
     *
     * @return array $records found in DB.
     */
    public static function all() : array
    {
        global $wpdb;

        $table   = self::get_table();

        $results = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);

        $records = self::instances_from_array( $results );        

        return $records;
    }

    /**
     * Return model instances created from (DB) array.
     *
     * @param array $results from DB.
     * @return $array $records of Models.
     */
    protected static function instances_from_array( array $results ) : array 
    {
        $records     = array();
        $primary_key = self::get_primary_key();

        foreach ($results as $result) :
            $class = get_called_class();
            $record = new $class($result[ $primary_key ]);

            foreach ($result as $key => $value) :
                if ($key !== $primary_key) :
                    $record->set($key, $value);
                endif;
            endforeach;

            $records[] = $record;
        endforeach;

        return $records;
    }
}
