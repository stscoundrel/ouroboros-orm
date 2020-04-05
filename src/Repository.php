<?php
/**
 * Repository class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// Contracts.
use Silvanus\Ouroboros\Contracts\RepositoryInterface;
use Silvanus\Ouroboros\Contracts\ModelInterface;

/**
 * --> Repository Pattern implementation for Ouroboros models
 * --> CRUD methods for abstracting model away from business logic.
 */
class Repository implements RepositoryInterface
{   
    /**
     * Model of repository.
     */
    protected $model;   

    /**
     * Class constructor.
     *
     * @param ModelInterface $model Ouroboros model.
     */
    public function __construct( ModelInterface $model ) {
        $this->model = $model;      
    }

    /**
     * Get all records from model.
     *
     * @return array $records from db.
     */
    public function all() {
        return $this->model->all();
    }

    /**
     * Get record from model by id.
     *
     * @param int $id of record.
     * @return Model $record from db.
     */
    public function get( $id ) {
        return $this->model->find( $id );
    }

    /**
     * Create new record to DB
     *
     * @param array $attributes of record.
     * @return Model $model that was created.
     */
    public function create( $attributes ) {
        $id = $this->model->create( $attributes );

        return $this->get( $id );
    }

    /**
     * Update existing record to DB
     *
     * @param int $id of record.
     * @param array $attributes of record.
     */
    public function update( $attributes ) {
        $this->model->update( $attributes );
    }

    /**
     * Delete record from DB
     *
     * @param int $id of record.
     */
    public function delete( $id ) {
        $this->model->delete( $id );
    }
}
