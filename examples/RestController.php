<?php

namespace Your\namespace;

// Ouroboros classes.
use Silvanus\Ouroboros\RestController;

class MovieController extends RestController
{

    /**
     * You can replace namespace or
     * resource name via class properties.
     *
     * Namespace & resource form REST endpoint paths,
     * like wp-json/ouroboros/movie
     */

    /**
     * Default namespace is "ouroboros".
     */
    protected $namespace = 'acme';

    /**
     * Default resource is lowercase name of model.
     * For "Movie" resource is "movie".
     */
    protected $resource = 'movies';
}
