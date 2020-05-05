<?php
/**
 * MissingID exception
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions\Model;

use \Exception;

/**
 * Handle exception for missing model allowed_attributes
 */
class MissingIDException extends Exception
{
    protected $message = 'Missing ID in model update statement. Can not update.';
}
