<?php

/**
 * Mock WP_CLI class.
 */
class WP_CLI
{

    /**
     * Store calls to add commands.
     */
    public static $added_commands = array();

    /**
     * Store success messages.
     */
    public static $successes = array();

    public static function add_command(string $command, $class)
    {
        static::$added_commands[] = array( $command, $class );
    }

    public static function success(string $message)
    {
        static::$successes[] = $message;
    }
}
