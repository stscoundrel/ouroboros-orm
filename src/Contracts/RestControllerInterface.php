<?php
/**
 * REST Controller Interface
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Contracts;

use \WP_REST_Request;

interface RestControllerInterface
{

    public function register_routes();

    public function get_items(WP_REST_Request $request);

    public function get_item(WP_REST_Request $request);
}
