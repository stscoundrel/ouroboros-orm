<?php

namespace Silvanus\Ouroboros\Tests\Fixtures;

// Ouroboros classes.
use Silvanus\Ouroboros\Schema;

class BookSchema extends Schema
{

    /**
     * Name of database table to be created.
     * No prefix needed, Schema will figure it out.
     */
    protected static $table = 'books';

    /**
     * Columns to be created for table.
     */
    protected static $columns = array(
        'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
        'name' => 'varchar(255) NOT NULL',
        'author' => 'varchar(255) NOT NULL',
        'year' => 'varchar(255) NOT NULL',
    );
}
