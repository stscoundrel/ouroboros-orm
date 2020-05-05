<?php
/**
 * NoSchemaSet exception
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions\Migration;

use \Exception;

/**
 * Handle exception for missing migration schema.
 */
class NoSchemaSetException extends Exception
{
    protected $message = 'Missing Schema property in Migration.';
}
