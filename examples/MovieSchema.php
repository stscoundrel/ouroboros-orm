<?php

namespace Your\namespace;

// Ouroboros classes.
use Silvanus\Ouroboros\Schema;

class MovieSchema extends Schema {

	/**
	 * Name of database table to be created.
	 * No prefix needed, Schema will figure it out.
	 */
	protected static $table = 'movie';

	/**
	 * Columns to be created for table.
	 */
	protected static $columns = array(
		'id' => 'bigint(20) NOT NULL AUTO_INCREMENT',
		'name' => 'varchar(255) NOT NULL',
	);
}
