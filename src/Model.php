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
use Silvanus\Ouroboros\Contracts\DatabaseAccessInterface;
use Silvanus\Ouroboros\Contracts\HasDatabaseAccessInterface;

// Exceptions.
use Silvanus\Ouroboros\Exceptions\NoTableSetException;
use Silvanus\Ouroboros\Exceptions\Model\NoAllowedAttributesException;
use Silvanus\Ouroboros\Exceptions\Model\MissingIDException;

// Default DB access.
use Silvanus\Ouroboros\DatabaseAccess;

/**
 * --> Models custom DB table
 * --> Common data manipulation meethods.
 */
class Model implements ModelInterface, TableInterface, HasDatabaseAccessInterface
{

    /**
     * Table name in database.
     *
     * @var ?string
     */
    protected static $table;

    /**
     * Primary key of table.
     * Default: id.
     * Used to fetch records by id.
     *
     * @var string
     */
    protected static $primary_key = 'id';

    /**
     * Model attributes
     * key => value array.
     */
    protected $attributes;

    /**
     * Allowed attributes
     * List of keys to be expected in DB.
     */
    protected static $allowed_attributes;

    /**
     * ID of fetched record.
     *
     * @var ?int
     */
    public $id;

    /**
     * Database access instance.
     *
     * @var ?DatabaseAccessInterface
     */
    protected static $db_access = null;

    /**
     * Class constructor.
     *
     * @param int $id of record in DB.
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    /**
     * Get database access instance.
     * If not provided, use default.
     *
     * @return DatabaseAccessInterface
     */
    public static function get_database_access() : DatabaseAccessInterface
    {
        if (static::$db_access === null) :
            $db_access = new DatabaseAccess();
            static::set_database_access($db_access);
            return $db_access;
        endif;

        return static::$db_access;
    }

    /**
     * Set database access instance.
     *
     * @param DatabaseAccessInterface $accessor to use.
     *
     * @return void
     */
    public static function set_database_access(DatabaseAccessInterface $accessor)
    {
        static::$db_access = $accessor;
    }

    /**
     * Get table name with prefix.
     *
     * @return string $table name.
     */
    public static function get_table() : string
    {
        if (! static::$table) :
            throw new NoTableSetException();
        endif;

        return static::get_database_access()->get_prefix() . static::$table;
    }

    /**
     * set table name
     *
     * @param string $table name.
     *
     * @return void
     */
    public static function set_table(string $table)
    {
        static::$table = $table;
    }

    /**
     * Return ID of model entry.
     *
     * @return int
     */
    public function get_id() : ?int
    {
        return $this->id;
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
     *
     * @return void
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
    public function get_attributes(): array
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
     *
     * @return void
     */
    public function set(string $key, $value)
    {
        if (static::is_allowed($key)) :
            $this->attributes[ $key ] = $value;
        endif;
    }

    /**
     * Unset model attribute.
     *
     * @param string $key of attribute.
     *
     * @return void
     */
    public function unset(string $key): void
    {
        unset($this->attributes[ $key ]) ;
    }

    /**
     * Check if given key is allowed.
     * Only allowed keys can be set to attributes.
     *
     * @param string $key of field.
     * @return bool
     */
    public static function is_allowed(string $key) : bool
    {
        if (! static::$allowed_attributes) :
            throw new NoAllowedAttributesException();
        endif;

        return in_array($key, static::$allowed_attributes);
    }

    /**
     * Filter array of client-given attributes.
     * Return only allowed for this model.
     *
     * @param array $attributes to filter.
     * @return array $allowed_attributes that have been filtered.
     */
    private static function filter_attributes(array $attributes) : array
    {
        $allowed_attributes = array();

        foreach ($attributes as $key => $value) :
            if (self::is_allowed($key)) :
                $allowed_attributes[$key] = $value;
            endif;
        endforeach;

        return $allowed_attributes;
    }

    /**
     * Creates new record in DB.
     *
     * @param array $attributes to create, optional.
     * @return int $id of created entry.
     */
    public static function create(array $attributes = array()) : int
    {
        $id = static::get_database_access()->insert(self::get_table(), self::filter_attributes($attributes));

        return $id;
    }

    /**
     * Updates record in DB.
     *
     * @param array $attributes to update, optional.
     *
     * @return void
     */
    public static function update(array $attributes = array())
    {

        if (array_key_exists(self::get_primary_key(), $attributes)) :
            $id = $attributes[ self::get_primary_key() ];
        else :
            throw new MissingIDException();
        endif;

        $attributes = self::filter_attributes($attributes);

        static::get_database_access()->update(self::get_table(), $attributes, self::get_primary_key(), $id);
    }

    /**
     * Delete record from DB.
     *
     * @param int $id of record in DB.
     *
     * @return void
     */
    public static function delete(int $id)
    {
        static::get_database_access()->delete(self::get_table(), self::get_primary_key(), $id);
    }

    /**
     * Find record from DB by id.
     *
     * @param int $id of record.
     *
     * @return ?ModelInterface
     */
    public static function find(int $id) : ?ModelInterface
    {
        $db_id = strval($id);

        $primary_key = self::get_primary_key();

        $record = self::where($primary_key, $db_id);

        if (count($record) === 1) :
            $record = $record[0];
        else :
            return null;
        endif;

        return $record;
    }

    /**
     * Find record from DB by key & value pair.
     *
     * @param string $column_name in table.
     * @param string $column_value in table.
     * @return array $records.
     */
    public static function where(string $column_name, string $column_value) : array
    {
        $column_name = sanitize_text_field($column_name);
        $column_value = sanitize_text_field($column_value);

        $table       = self::get_table();

        if (! is_numeric($column_name)) :
            $column_value = "'$column_value'";
        endif;

        $results = static::get_database_access()->get_results($table, $column_name, $column_value);

        $records = self::instances_from_array($results);

        return $records;
    }

    /**
     * Get all records from DB.
     *
     * @return array $records found in DB.
     */
    public static function all() : array
    {

        $results = static::get_database_access()->get_all(self::get_table());

        $records = self::instances_from_array($results);

        return $records;
    }

    /**
     * Persist current instance to DB.
     * --> If ID, update.
     * --> If not, create new.
     *
     * @return void
     */
    public function save()
    {

        $attributes = $this->get_attributes();

        if ($this->id !== null) :
            $attributes[self::get_primary_key()] = $this->id;
            self::update($attributes);
        else :
            $id = self::create($attributes);
            $this->id = $id;
        endif;
    }

    /**
     * Return model instances created from (DB) array.
     *
     * @param array $results from DB.
     * @return array $records of Models.
     */
    private static function instances_from_array(array $results) : array
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
