<?php
use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Model;

// Ouroboros exceptions.
use Silvanus\Ouroboros\Exceptions\NoTableSetException;
use Silvanus\Ouroboros\Exceptions\Model\NoAllowedAttributesException;
use Silvanus\Ouroboros\Exceptions\Model\MissingIDException;

// Fixtures.
use Silvanus\Ouroboros\Tests\Fixtures\BookModel;

final class ModelTest extends TestCase
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

    public function testCannotGetMissingTable(): void
    {
        $this->expectException(NoTableSetException::class);

        $model = new Model();
        $model::get_table();
    }

    public function testCannotGetMissingAllowedAttributes(): void
    {
        $this->expectException(NoAllowedAttributesException::class);

        $model = new Model();
        $model::is_allowed('test');
    }

    public function testCannotUpdateModelWithMissingId(): void
    {
        $this->expectException(MissingIDException::class);

        Model::update(array('name' => 'Viking Language 1', 'author' => 'Jesse L. Byock'));
    }

    public function testInstanceCanBeCreated()
    {
        $model = new Model();

        $this->assertInstanceOf(
            Model::class,
            new Model()
        );
    }

    public function testModelCanGetAndSetAttributes()
    {
        $model = new BookModel();
        $model->set('name', 'Reamde');
        $model->set('author', 'Alastair Reynolds');

        $this->assertEquals(
            'Reamde',
            $model->get('name')
        );

        $this->assertEquals(
            'Alastair Reynolds',
            $model->get('author')
        );

        $model->set('name', 'Snow Crash');

        $this->assertEquals(
            'Snow Crash',
            $model->get('name')
        );
    }

    public function testModelCanGetAndSetPrimaryKey()
    {

        $this->assertEquals(
            'id',
            BookModel::get_primary_key()
        );

        BookModel::set_primary_key('book_id');

        $this->assertEquals(
            'book_id',
            BookModel::get_primary_key()
        );    
    }
}