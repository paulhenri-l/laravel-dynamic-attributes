<?php

namespace PaulhenriL\LaravelDynamicAttributes;

interface DynamicAttribute
{
    /**
     * Get the given dynamic attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * Set the given dynamic attribute.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void;
}
