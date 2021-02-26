<?php
/**
 * REST Controller class
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros;

// Contracts.
use Silvanus\Ouroboros\Contracts\RestControllerInterface;
use Silvanus\Ouroboros\Contracts\ModelInterface;

// Exceptions.
use Silvanus\Ouroboros\Exceptions\NoModelSetException;

use \ReflectionClass;
use \WP_REST_Request;

/**
 * --> Serve model data over REST.
 */
class RestController implements RestControllerInterface
{

    /**
     * Model the REST endpoint is using.
     */
    protected $model;

    /**
     * Namespace of model.
     */
    protected $namespace;

    /**
     * Resource name of model.
     */
    protected $resource;

    public function __construct(ModelInterface $model)
    {
        $this->model = $model;

        if (! $this->namespace) :
            $this->namespace = 'ouroboros';
        endif;

        if (! $this->resource) :
            $resource        = new ReflectionClass($model);
            $this->resource  = strtolower($resource->getShortName());
        endif;
    }

    /**
     * Get controller REST namespace.
     *
     * @return string
     */
    public function get_namespace() : string
    {
        return $this->namespace;
    }

    /**
     * Get controller REST resource name.
     *
     * @return string
     */
    public function get_resource() : string
    {
        return $this->resource;
    }

    /**
     * Return model class associated with endpoint.
     *
     * @return ModelInterface $model of endpoint.
     */
    private function get_model() : ModelInterface
    {
        return $this->model;
    }

    /**
     * Register available routes.
     *
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->resource,
            array(
                array(
                    'methods'   => 'GET',
                    'callback'  => array($this, 'get_items'),
                ),
            )
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->resource . '/(?P<id>[\d]+)',
            array(
                array(
                    'methods'   => 'GET',
                    'callback'  => array($this, 'get_item'),
                ),
            )
        );
    }

    /**
     * Get all items.
     *
     * @param WP_REST_Request $request to handle.
     *
     * @return array
     */
    public function get_items(WP_REST_Request $request)
    {
        $items = array();

        $results =  $this->get_model()->all();

        foreach ($results as $result) :
            $items[] = $this->prepare_item($result);
        endforeach;

        return $items;
    }

    /**
     * Get all items.
     *
     * @param WP_REST_Request $request to handle.
     *
     * @return ?array
     */
    public function get_item(WP_REST_Request $request) : ?array
    {
        $id = $request->get_param('id');

        if ($id) :
            $result = $this->get_model()->find($id);

            if ($result) :
                return $this->prepare_item($result);
            endif;
        endif;

        return null;
    }

    /**
     * Prepare model instance data to be used as array.
     *
     * @param ModelInterface $model to handle.
     * @return array $item data in JSONable format.
     */
    private function prepare_item(ModelInterface $model) : array
    {
        $item = array(
            'id' => $model->get_id(),
        );

        foreach ($model->get_attributes() as $key => $value) :
            $item[ $key ] = $value;
        endforeach;

        return $item;
    }
}
