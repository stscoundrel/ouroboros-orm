<?php
/**
 * NoTableSet exception
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions\Model;

use \Exception;

/**
 * Handle exception for missing model allowed_attributes
 */
class NoTableSetException extends Exception
{
    protected $message = 'No database table set in Model. Add static table string property to model.';
}
