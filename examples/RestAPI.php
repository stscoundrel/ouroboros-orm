<?php

// Ouroboros classes.
use Silvanus\Ouroboros\RestController;

// Your model class.
use Your\namespace\Movie;

class App
{

    /**
     * Class constructor.
     * Whichever place you want to add_action in.
     */
    public function __construct()
    {
        // Register rest endpoints.
        add_action('rest_api_init', array( $this, 'register_movies_endpoint' ));
    }

    public function register_movies_endpoint()
    {
        // Get Movie model instance.
        $model = new Movie();

        // Associate Ouroboros REST Controller with model.
        $movies_controller = new RestController($model);

        /**
        * Register endpoints.
        * Default path is /wp-json/ouroboros/[LOWERCASE_MODEL_NAME]
        * So for our movie class /wp-json/ouroboros/movie
        */
        $movies_controller->register_routes();
    }
}
