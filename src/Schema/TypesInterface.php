<?php
/**
 * Schema column types
 *
 * @package Ouroboros.
 */

namespace Silvanus\Ouroboros\Schema;

/**
 * --> Handle table column definitions
 */
interface TypesInterface
{
    /**
     * CHAR types
     *
     * @var array
     */
    const CHAR_TYPES = array(
        'CHAR',
        'VARCHAR',
        'TINYTEXT',
        'TEXT',
        'MEDIUMTEXT',
        'LONGTEXT'
    );

    /**
     * INT types
     *
     * @var array
     */
    const INT_TYPES = array(
        'CHAR',
        'VARCHAR',
        'TINYTEXT',
        'TEXT',
        'MEDIUMTEXT',
        'LONGTEXT'
    );
}
