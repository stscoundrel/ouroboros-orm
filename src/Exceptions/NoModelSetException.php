<?php
/**
 * NoModelSet exception.
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions;

use \Exception;

/**
 * Handle exception for missing model property.
 */
class NoModelSetException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'No model set in class. Add model property for the class to refer to.';
}
