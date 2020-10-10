<?php

namespace Silvanus\Ouroboros\Tests\Fixtures;

// Ouroboros classes.
use Silvanus\Ouroboros\Model;
use Silvanus\Ouroboros\Contracts\ModelInterface;

/**
 * Model instance made to pass as Model,
 * but basically just spy Repository behavior.
 */
class FakeModel extends Model
{

    /**
     * Name of database without prefix,
     */
    protected static $table = 'books';

    /**
     * Optional: primary key.
     * Defaults to "id"
     */
    protected static $primary_key = 'id';

    /**
     * Allowed attributes to edit.
     */
    protected static $allowed_attributes = array( 'name', 'author', 'year', 'genre' );

    /**
     * Store calls to update method.
     */
    public static $updates = array();

    /**
     * Store calls to delete method.
     */
    public static $deletes = array();

    public static function all() : array
    {
        $fake1 = new FakeModel();
        $fake1->set('name', 'test1');
        $fake2 = new FakeModel();
        $fake2->set('name', 'test2');
        $fake3 = new FakeModel();
        $fake3->set('name', 'test3');

        return array(
            $fake1,
            $fake2,
            $fake3,
        );
    }

    public static function find(int $id) : ModelInterface
    {
        if ($id === 1527) :
            $fake = new FakeModel();
            $fake->set('name', 'Fake from create');

            return $fake;
        endif;

        if ($id === 666) :
            $fake = new FakeModel();
            $fake->set('name', 'Fake from get');

            return $fake;
        endif;

        if ($id === 1989) :
            $fake = new FakeModel();
            $fake->set('name', 'Fake from REST');

            return $fake;
        endif;

        return new FakeModel();
    }

    public static function create(array $attributes = array()) : int
    {
        return 1527;
    }

    public static function update(array $attributes = array())
    {
        static::$updates[] = $attributes;
    }

    public static function delete(int $id)
    {
        static::$deletes[] = $id;
    }
}
