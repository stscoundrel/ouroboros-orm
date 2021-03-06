<?php

namespace Silvanus\Ouroboros\Tests;

use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Schema;

// Ouroboros exceptions.
use Silvanus\Ouroboros\Exceptions\NoTableSetException;

// Fixtures.
use Silvanus\Ouroboros\Tests\Fixtures\BookSchema;

// Test Doubles.
use Silvanus\Ouroboros\Tests\TestDoubles\WPDB;

final class SchemaTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
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

    public function testCannotGetMissingTable(): void
    {
        $this->expectException(NoTableSetException::class);
        
        Schema::get_table();
    }

    public function testCanGetTableIfSet(): void
    {
        $this->assertEquals(
            'books',
            BookSchema::get_table()
        );
    }

    public function testCannotGetMissingTableWithPrefix(): void
    {
        $this->expectException(NoTableSetException::class);
        
        Schema::get_table_with_prefix();
    }

    public function testCanGetTableWithPrefixIfSet(): void
    {
        $this->assertEquals(
            'wp_books',
            BookSchema::get_table_with_prefix()
        );
    }

    public function testCanGetDefaultPrimaryKey(): void
    {
        $this->assertEquals(
            'id',
            Schema::get_primary_key()
        );
    }

    public function testCanGetAndSetCustomPrimaryKey(): void
    {
        Schema::set_primary_key('book_id');

        $this->assertEquals(
            'book_id',
            Schema::get_primary_key()
        );

        Schema::set_primary_key('another_id');

        $this->assertEquals(
            'another_id',
            Schema::get_primary_key()
        );

        Schema::set_primary_key('id');

        $this->assertEquals(
            'id',
            Schema::get_primary_key()
        );
    }

    public function testCanGetAndAddColumns(): void
    {
        $this->assertEquals(
            'varchar(255) NOT NULL',
            BookSchema::get_column('name')
        );

        BookSchema::add_column('isbn', 'varchar(255) NOT NULL');

        $this->assertEquals(
            'varchar(255) NOT NULL',
            BookSchema::get_column('isbn')
        );
    }

    public function testCanCreateTable(): void
    {
        // phpcs:ignore
        $expected = 'CREATE TABLE wp_books ( id bigint(20) NOT NULL AUTO_INCREMENT, name varchar(255) NOT NULL, author varchar(255) NOT NULL, year varchar(255) NOT NULL, isbn varchar(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (id) ) ;';

        $this->assertEquals(
            $expected,
            BookSchema::create()
        );
    }

    public function testCanDropTable(): void
    {
        $expected = 'DROP TABLE  IF EXISTS wp_books;';
        
        $this->assertEquals(
            $expected,
            BookSchema::drop()
        );
    }

    public function testCanSetPropertiesInConstruct(): void
    {
        $columns = array(
            'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(255) NOT NULL'
        );
        $schema = new Schema('books', $columns);

        $this->assertEquals(
            'books',
            $schema::get_table()
        );

        $this->assertEquals(
            'wp_books',
            $schema::get_table_with_prefix()
        );

        $this->assertEquals(
            array(
                'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
                'name' => 'varchar(255) NOT NULL'
            ),
            $schema::get_columns(),
        );
    }

    public function testCanSetPropertiesAfterConstruct(): void
    {
        $columns = array(
            'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(255) NOT NULL'
        );
        $schema = new Schema();
        $schema::set_table('books');
        foreach ($columns as $key => $value) :
            $schema::add_column($key, $value);
        endforeach;

        $this->assertEquals(
            'books',
            $schema::get_table()
        );

        $this->assertEquals(
            'wp_books',
            $schema::get_table_with_prefix()
        );

        $this->assertEquals(
            array(
                'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
                'name' => 'varchar(255) NOT NULL'
            ),
            $schema::get_columns(),
        );
    }

    public function testCanInstantiateWithCustomArguments(): void
    {
        $book_schema = new BookSchema('custom_table', null, 'custom_primary_key');

        $this->assertEquals(
            'custom_table',
            $book_schema::get_table()
        );

        $this->assertEquals(
            'custom_primary_key',
            $book_schema::get_primary_key()
        );
    }

    public function testUsesDefaultPrimaryKeyWhenNoGiven(): void
    {
        $book_schema = new BookSchema(null, null, null);

        $this->assertEquals(
            'id',
            $book_schema::get_primary_key()
        );
    }
}
