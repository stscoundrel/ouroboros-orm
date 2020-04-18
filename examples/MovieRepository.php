<?php

namespace Your\Namespace;

// Ouroboros classes.
use Silvanus\Ouroboros\Repository;

// Model to be associated with Repository.
use Your\Namespace\MovieModel;

class MovieRepository extends Repository
{

   /**
    * (Parent) Repository constructor accepts ModelInterface.
    *
    * It is preferable to inject the model instance outside the repository.
    *
    * To hardwire your repository to a certain model,
    * replace constructor like this:
    */
    public function __construct() {
        $model = new MovieModel();

        parent::__construct( $model );
    }


    /**
     * Thats it!
     * You can add your custom repository methods here.
     * Or use standard ones like:
     *
     * --> all();
     * --> get($id)
     * --> create(array $data)
     * --> update(array $data)
     * --> delete($id)
     *
     */
}
