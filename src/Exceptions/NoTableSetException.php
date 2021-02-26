<?php
/**
 * NoTableSet exception
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions;

use \Exception;

/**
 * Handle exception for missing table property.
 */
class NoTableSetException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'No database table set in class. Add static table string property to model / schema.';
}
