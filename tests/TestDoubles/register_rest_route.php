<?php

namespace Silvanus\Ouroboros;

/**
 * Test double for wp core function.
 */
function register_rest_route($namespace, $resource, $arguments)
{

    global $registered_rest_routes;

    if (! $registered_rest_routes) :
        $registered_rest_routes = array();
    endif;

    $registered_rest_routes[] = array(
        'namespace' => $namespace,
        'resource'  => $resource,
        'arguments' => $arguments,
    );
}
