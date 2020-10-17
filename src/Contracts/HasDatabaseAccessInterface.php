<?php
/**
 * Has Database Access Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

// Contracts.
use Silvanus\Ouroboros\Contracts\DatabaseAccessInterface;

interface HasDatabaseAccessInterface
{
    public function get_database_access() : DatabaseAccessInterface;

    public function set_database_access(DatabaseAccessInterface $accessor);
}
