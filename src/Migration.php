<?php
/**
 * Abstract Migration class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

/**
 * --> Receive table schema
 * --> Create table based on schema
 * --> Or drop table of schema
 */
abstract class Migration
{

    /**
     * WP CLI command base
     *
     * @var string.
     */
    protected $command;

    /**
     * Table schema
     *
     * @var Schema.
     */
    protected $schema;

    /**
     * Class constructor
     * --> Receive Schema object
     * --> Hook up class to WP CLI
     * --> Use up & down commands with Schema
     */
    public function __construct()
    {
        /**
         * Expose our CLI commands through classname keyword
         * Example: wp [NAME_OF_MIGRATION] up
         */
        \WP_CLI::add_command('ouroboros migrate ' . $this->command, get_called_class());
    }

    /**
     * Set migration table schema
     *
     * @param Schema $schema object of table.
     */
    protected function set_schema($schema)
    {
        $this->schema = $schema;
    }

    /**
     * Return migration schema
     *
     * @return Schema $schema object of table.
     */
    protected function get_schema()
    {
        return $this->schema;
    }

    /**
     * Create table, save columns.
     */
    public function up()
    {
        \WP_CLI::log('up!');
        var_dump($this->get_schema());
    }

    /**
     * Drop table, destroy all.
     */
    public function down()
    {
        \WP_CLI::log('down!');
    }
}
