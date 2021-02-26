<?php

namespace Silvanus\Ouroboros\Tests;

use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\RestController;

// Ouroboros exceptions.
use Silvanus\Ouroboros\Exceptions\NoModelSetException;

// Fixtures.
use Silvanus\Ouroboros\Tests\Fixtures\BookModel;
use Silvanus\Ouroboros\Tests\Fixtures\FakeModel;
use Silvanus\Ouroboros\Tests\Fixtures\BookController;

use \WP_REST_Request;

final class RestControllerTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
        require_once('TestDoubles/WP_REST_Request.php');
        require_once('TestDoubles/register_rest_route.php');
    }

    public function testInstanceCanBeCreated(): void
    {
        $model      = new BookModel();
        $controller = new RestController($model);

        $this->assertInstanceOf(
            RestController::class,
            $controller
        );
    }

    public function testUsesDefaultNamespaceAndDefaultResource(): void
    {
        $model      = new BookModel();
        $controller = new RestController($model);

        $this->assertEquals(
            'ouroboros',
            $controller->get_namespace(),
        );

        $this->assertEquals(
            'bookmodel',
            $controller->get_resource(),
        );
    }

    public function testCanUseCustomNamespaceAndResource(): void
    {
        $model      = new BookModel();
        $controller = new BookController($model);

        $this->assertEquals(
            'myplugin',
            $controller->get_namespace(),
        );

        $this->assertEquals(
            'books',
            $controller->get_resource(),
        );
    }

    public function testRegistersRestRoutes(): void
    {
        // Global set up by test double.
        global $registered_rest_routes;

        $model      = new BookModel();
        $controller = new RestController($model);
        $controller->register_routes();

        $this->assertContains(
            array(
                'namespace' => 'ouroboros',
                'resource'  => '/bookmodel',
                'arguments' => array(
                    array(
                        'methods'   => 'GET',
                        'callback'  => array($controller, 'get_items'),
                    ),
                )
            ),
            $registered_rest_routes,
        );

        $this->assertContains(
            array(
                'namespace' => 'ouroboros',
                'resource'  => '/bookmodel/(?P<id>[\d]+)',
                'arguments' => array(
                    array(
                        'methods'   => 'GET',
                        'callback'  => array($controller, 'get_item'),
                    ),
                )
            ),
            $registered_rest_routes,
        );
    }

    public function testGetsItem(): void
    {
        $model      = new FakeModel();
        $controller = new RestController($model);
        $request    = new WP_REST_Request();
        $item       = $controller->get_item($request);

        $this->assertTrue(
            is_array($item),
            true,
        );

        $this->assertEquals(
            'Fake from REST',
            $item['name'],
        );
    }

    public function testGetsItems(): void
    {
        $model      = new FakeModel();
        $controller = new RestController($model);
        $request    = new WP_REST_Request();
        $items      = $controller->get_items($request);

        $this->assertEquals(
            count($items),
            3
        );

        $this->assertEquals(
            $items[0]['name'],
            'test1'
        );

        $this->assertEquals(
            $items[2]['name'],
            'test3'
        );
    }
}
