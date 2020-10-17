<?php
/**
 * Migration Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

// Contracts.
use Silvanus\Ouroboros\Contracts\SchemaInterface;

interface MigrationInterface
{

    public function up();

    public function down();

    public function get_schema() : SchemaInterface;

    public function set_schema();
}
