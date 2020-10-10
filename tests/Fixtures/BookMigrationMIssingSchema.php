<?php

namespace Silvanus\Ouroboros\Tests\Fixtures;

// Ouroboros classes.
use Silvanus\Ouroboros\Migration;

// Local Schema class
use Silvanus\Ouroboros\Tests\Fixtures\BookSchema;

/**
 * BookMigration class to be called in CLI.
 */
class BookMigrationMissingSchema extends Migration
{

    /**
     * CLI command base.
     * Use "wp ouroboros migrate books up" or down.
     */
    protected $command = 'books';

    /**
     * Set Schema object to props.
     * Only required method.
     */
    public function set_schema()
    {
    }
}
