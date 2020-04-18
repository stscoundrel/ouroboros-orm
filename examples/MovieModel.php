<?php

namespace Your\Namespace;

// Ouroboros classes.
use Silvanus\Ouroboros\Model;

class Movie extends Model
{

    /**
     * Name of database without prefix,
     */
    protected static $table = 'movies';

    /**
     * Optional: primary key.
     * Defaults to "id"
     */
    protected static $primary_key = 'id';


    /**
     * Thats it!
     * You can add your custom model method here.
     * Or use standard ones like:
     *
     * Attributes:
     * - Get
     * - Set
     *
     * CRUD:
     * - Find
     * - Create
     * - Update
     * - Delete
     * - All
     *
     */
}
