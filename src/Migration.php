<?php
/**
 * Abstract Migration class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// Contracts.
use Silvanus\Ouroboros\Contracts\MigrationInterface;
use Silvanus\Ouroboros\Contracts\SchemaInterface;

// Exceptions.
use Silvanus\Ouroboros\Exceptions\Migration\NoSchemaSetException;

// WP deps.
use \WP_CLI;

/**
 * --> Receive table schema
 * --> Create table based on schema
 * --> Or drop table of schema
 */
abstract class Migration implements MigrationInterface
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

        // Set schema defined in child class.
        $this->set_schema();

        /**
         * Expose our CLI commands through classname keyword
         * Example: wp ouroboros migrate [NAME_OF_MIGRATION] up
         */
        WP_CLI::add_command('ouroboros migrate ' . $this->command, get_called_class());
    }

    /**
     * Set migration table schema
     */
    abstract public function set_schema();

    /**
     * Return migration schema
     *
     * @return Schema $schema object of table.
     */
    public function get_schema() : SchemaInterface
    {
        if (! $this->schema) :
            throw new NoSchemaSetException();
        endif;
        
        return $this->schema;
    }

    /**
     * Create table, save columns.
     */
    public function up()
    {
        $schema = $this->get_schema();

        $schema::create();

        WP_CLI::success('Migration ran, up');
    }

    /**
     * Drop table, destroy all.
     */
    public function down()
    {
        $schema = $this->get_schema();

        $schema::drop();

        WP_CLI::success('Migration ran, down');
    }
}
