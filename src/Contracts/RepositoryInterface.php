<?php
/**
 * Repository Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;


interface RepositoryInterface {

	public function all();

    public function get( $id );

    public function create( array $data );

    public function update( array $data );

    public function delete( $id );

}
