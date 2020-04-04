<?php
/**
 * Model Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;


interface ModelInterface {

	public static function find( $id );

	public function create( $attributes );

	public function update( $attributes );

	public function delete( $id );	

}
