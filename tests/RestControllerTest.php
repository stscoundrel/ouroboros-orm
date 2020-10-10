<?php
use PHPUnit\Framework\TestCase;

// Ouroboros deps.
use Silvanus\Ouroboros\RestController;

// Ouroboros exceptions.
use Silvanus\Ouroboros\Exceptions\NoModelSetException;

// Fixtures.
use Silvanus\Ouroboros\Tests\Fixtures\BookModel;
use Silvanus\Ouroboros\Tests\Fixtures\BookController;

// Test Doubles.
//use Silvanus\Ouroboros\Tests\TestDoubles\WPDB;

final class RestControllerTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
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
}
