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

// Test Doubles.
use Silvanus\Ouroboros\Tests\TestDoubles\WPDB;

final class ModelTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
        require_once('TestDoubles/sanitize_text_field.php');
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

        BookModel::set_table('books');
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

        BookModel::set_primary_key('id');
    }

    public function testModelCanAddEntryToDatabase()
    {
        $attributes = array( 'name' => 'Cryptonomicon', 'author' => 'Neal Stephenson' );

        $id = BookModel::create($attributes);

        $this->assertEquals(
            1,
            $id
        );

        $attributes['id'] = $id;

        $this->assertContains(
            $attributes,
            $this->wpdb->created
        );
    }

    public function testModelCanUpdateEntryInDatabase()
    {
        $attributes = array( 'name' => 'Cryptonomicon', 'author' => 'Neal Stephenson' );

        BookModel::create($attributes);
        //var_dump( $this->wpdb->created );
        $attributes = array( 'id' => 1, 'name' => 'Anathema' );
        BookModel::update($attributes);
        //var_dump( $this->wpdb->created );

        $entry;
        foreach ($this->wpdb->created as $created) :
            if ($created['id'] === $attributes['id']) :
                $entry = $created;
            endif;
        endforeach;

        $this->assertEquals(
            $attributes['name'],
            $created['name']
        );
    }

    public function testModelCanDeleteEntryFromDatabase()
    {
        BookModel::delete(666);

        $this->assertContains(
            666,
            $this->wpdb->deleted
        );
    }

    public function testModelCanFindEntryFromDatabase()
    {
        BookModel::create(array( 'name' => 'Revenger', 'author' => 'Alastair Reynolds' ));
        BookModel::create(array( 'name' => 'Shadow Captain', 'author' => 'Alastair Reynolds' ));
        BookModel::create(array( 'name' => 'Bone Silence', 'author' => 'Alastair Reynolds' ));

        $expected = array( 'name' => 'Bone Silence', 'author' => 'Alastair Reynolds' );

        $this->assertEquals(
            $expected,
            BookModel::find(3)->get_attributes()
        );
    }
}
