<?php

namespace Silvanus\Ouroboros\Tests\Fixtures;

// Ouroboros classes.
use Silvanus\Ouroboros\RestController;

class BookController extends RestController
{

    /**
     * Default namespace is "ouroboros".
     */
    protected $namespace = 'myplugin';

    /**
     * Default resource is lowercase name of model.
     */
    protected $resource = 'books';
}
