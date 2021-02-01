<?php
/**
 * Database access class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// Contracts.
use Silvanus\Ouroboros\Contracts\DatabaseAccessInterface;

/**
 * --> Hides WPDB behind common interface.
 */
class DatabaseAccess implements DatabaseAccessInterface
{

    /**
     * Get prefix this WP installation uses for tables.
     */
    public function get_prefix() : string
    {
        global $wpdb;
        return $wpdb->prefix;
    }

    /**
     * Create new table in database.
     *
     * @param string $table name to create.
     * @param string $columns_sql parsed in Schema.

     * How WP wants this done:
     *
     * @link https://codex.wordpress.org/Creating_Tables_with_Plugins
     *
     * @return array
     */
    public function create_table(string $table, string $columns_sql)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // Parse SQL from columns.
        $sql = 'CREATE TABLE ' . $table . ' ( ' . $columns_sql . ' ) ' . $charset_collate . ';';

        /**
         * @psalm-suppress MissingFile
         */
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Execute using WordPress functions.
        return dbDelta($sql);
    }

    /**
     * Drop table from database.
     *
     * @param string $table name to create.
     */
    public function drop_table(string $table)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // Parse SQL from columns.
        $sql = 'DROP TABLE  IF EXISTS ' . $table . ';';

        // Execute using WPDB.
        return $wpdb->query($sql);
    }

    /**
     * Insert record into DB table.
     *
     * @param string $table name.
     * @param array $attributes fields.
     */
    public function insert(string $table, array $attributes) : int
    {
        global $wpdb;

        $wpdb->insert($table, $attributes);

        return $wpdb->insert_id;
    }

    /**
     * Update record in DB.
     *
     * @param string $table to use.
     * @param array $attributes to use.
     * @param string $primary_key to use.
     * @param int $id to delete.
     *
     * @return void
     */
    public function update(string $table, array $attributes, string $primary_key, int $id)
    {
        global $wpdb;

        $wpdb->update(
            $table,
            $attributes,
            array($primary_key => $id),
        );
    }

    /**
     * Delete record from DB.
     *
     * @param string $table to use.
     * @param string $primary_key to use.
     * @param int $id to delete.
     *
     * @return void
     */
    public function delete(string $table, string $primary_key, int $id)
    {
        global $wpdb;

        $wpdb->delete(
            $table,
            array($primary_key => $id),
        );
    }

    /**
     * Get results by column name & value
     *
     * @param string $table name.
     * @param string $column_name to query.
     * @param string $column_value to query.
     * @return array.
     */
    public function get_results(string $table, string $column_name, string $column_value)
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM $table WHERE $column_name = $column_value", ARRAY_A);
    }

    /**
     * Get all results from table.
     *
     * @param string $table name.
     * @return array.
     */
    public function get_all(string $table) : array
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
    }
}
