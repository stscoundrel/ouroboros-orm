<?php
use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Model;
use Silvanus\Ouroboros\Tests\Model\Fixtures\BookModel;

final class ModelDatabaseInteractionsTest extends TestCase
{
    /**
     * Mock global wpdb object.
     */
    protected function setUp(): void
    {
        global $wpdb;
        $wpdb = new stdClass();
        $wpdb->prefix = 'wp_';
    }

    public function testModelCanGetTableIfSet()
    {
        $this->assertEquals(
            'wp_books',
            BookModel::get_table()
        );        
    }

    public function testModelCanSetTable()
    {
        BookModel::set_table('bookies');

        $this->assertEquals(
            'wp_bookies',
            BookModel::get_table()
        );        
    }
}