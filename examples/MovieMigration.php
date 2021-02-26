<?php

namespace Your\Project;

// Ouroboros classes.
use Silvanus\Ouroboros\Migration;


// Local Schema class
use Your\namespace\MovieSchema;

/**
 * MovieMigration class to be called in CLI.
 */
class MovieMigration extends Migration
{

    /**
     * CLI command base.
     * Use "wp ouroboros migrate movies up" or down.
     */
    protected $command = 'movies';

    /**
     * Set Schema object to props.
     * Only required method.
     */
    public function set_schema()
    {
        $this->schema = new MovieSchema();

        // Alternatively, you can create new Schema on spot.

        // $columns = array(
        //     'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
        //     'name' => 'varchar(255) NOT NULL',
        // );

        // $this->schema = new Schema('movies', $columns);
    }
}
