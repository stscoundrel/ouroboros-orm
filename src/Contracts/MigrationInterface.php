<?php
/**
 * Migration Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

interface MigrationInterface
{

    public function up();

    public function down();

    public function get_schema();

    public function set_schema();
}
