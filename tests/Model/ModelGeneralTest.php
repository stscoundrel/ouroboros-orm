<?php
use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\Model;
use Silvanus\Ouroboros\Tests\Model\Fixtures\BookModel;

final class ModelGeneralTest extends TestCase
{
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