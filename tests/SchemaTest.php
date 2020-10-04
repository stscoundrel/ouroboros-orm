<?php
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

        Schema::set_primary_key('id');
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

}
