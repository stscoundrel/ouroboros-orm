<?php
/**
 * NoAllowedAttributes exception
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Exceptions\Model;

use \Exception;

/**
 * Handle exception for missing model allowed_attributes
 */
class NoAllowedAttributesException extends Exception
{
    // phpcs:ignore
    /**
     * @var string
     */
    protected $message = 'Allowed attributes for Model not declared. Add static allowed_attributes array property to whitelist model properties to be edited.';
}
