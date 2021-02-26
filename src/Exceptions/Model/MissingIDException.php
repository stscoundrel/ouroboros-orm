<?php
/**
 * MissingID exception
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions\Model;

use \Exception;

/**
 * Handle exception for missing ID argument.
 */
class MissingIDException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'Missing ID in model update statement. Can not update.';
}
