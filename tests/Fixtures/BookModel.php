<?php

namespace Silvanus\Ouroboros\Tests\Fixtures;

// Ouroboros classes.
use Silvanus\Ouroboros\Model;

class BookModel extends Model
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
}
