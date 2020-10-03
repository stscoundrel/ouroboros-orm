<?php

namespace Silvanus\Ouroboros\Tests\TestDoubles;

/**
 * Mock WPDB class.
 */
class WPDB
{

    /**
     * Table prefix, WP expects one.
     */
    public $prefix = 'wp_';

    /**
     * Created entries for checks.
     */
    public $created = array();

    /**
     * Deleted entries for checks.
     */
    public $deleted = array();

    /**
     * WP stores latest inserted ID in class property.
     */
    public $insert_id;

    /**
     * Store "created" data in class property.
     */
    public function insert(string $table, array $attributes)
    {
        $this->insert_id = count($this->created) + 1;

        $attributes['id'] = $this->insert_id;

        $this->created[] = $attributes;
    }

    /**
     * Update a "created" entry.
     */
    public function update(string $table, array $attributes, array $condition)
    {
        $entry_key = 0;
        $update_id = reset($condition);

        foreach ($this->created as $key => $created) :
            if ($created['id'] === $update_id) :
                $entry_key = $key;
            endif;
        endforeach;

        foreach ($attributes as $key => $value) :
            $this->created[ $entry_key ][$key] = $value;
        endforeach;
    }

    /**
     * Store "deleted" ids in class property.
     */
    public function delete(string $table, array $condition)
    {
        $this->deleted[] = reset($condition);
    }

    public function get_results(string $sql, $type)
    {
        if ($sql === "SELECT * FROM wp_books WHERE id = '3'") {
            $entry = array();

            foreach ($this->created as $created) :
                if ($created['id'] === 3) :
                    $entry = $created;
                endif;
            endforeach;

            return array($entry);
        }
    }
}
