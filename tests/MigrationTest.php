<?php

namespace Silvanus\Ouroboros\Tests;

use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Migration;

// Ouroboros exceptions.
use Silvanus\Ouroboros\Exceptions\Migration\NoSchemaSetException;

// Fixtures.
use Silvanus\Ouroboros\Tests\Fixtures\BookMigration;
use Silvanus\Ouroboros\Tests\Fixtures\BookMigrationMissingSchema;
use Silvanus\Ouroboros\Tests\Fixtures\BookSchema;

// Test Doubles.
use Silvanus\Ouroboros\Tests\TestDoubles\WPDB;

use \WP_CLI;

final class MigrationTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
        require_once('TestDoubles/WP_CLI.php');
        require_once('TestDoubles/constants.php');
    }

    /**
     * Mock global wpdb object.
     */
    protected function setUp(): void
    {
        global $wpdb;
        $wpdb = new WPDB();

        $this->wpdb = $wpdb;
    }

    public function testCreatingInstanceHooksUpCommand(): void
    {
        $migration = new BookMigration();

        $this->assertContains(
            array(
                'ouroboros migrate books',
                'Silvanus\Ouroboros\Tests\Fixtures\BookMigration'
            ),
            WP_CLI::$added_commands
        );
    }

    public function testCannotGetMissingSchema(): void
    {
        $this->expectException(NoSchemaSetException::class);
        
        $migration = new BookMigrationMissingSchema();
        $migration->get_schema();
    }

    public function testCanGetTableIfSet(): void
    {
        $migration = new BookMigration();

        $this->assertInstanceOf(
            BookSchema::class,
            $migration->get_schema()
        );
    }

    public function testCanRunUpCommand(): void
    {
        $migration = new BookMigration();
        $migration->up();

        $this->assertContains(
            'Migration ran, up',
            WP_CLI::$successes
        );
    }

    public function testCanRunDownCommand(): void
    {
        $migration = new BookMigration();
        $migration->down();

        $this->assertContains(
            'Migration ran, down',
            WP_CLI::$successes
        );
    }
}
