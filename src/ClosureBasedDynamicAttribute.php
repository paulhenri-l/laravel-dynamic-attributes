<?php

namespace PaulhenriL\LaravelDynamicAttributes;

use Closure;

class ClosureBasedDynamicAttribute implements DynamicAttribute
{
    /**
     * The getter Closure.
     *
     * @var Closure
     */
    protected $getter;

    /**
     * The setter Closure.
     *
     * @var Closure
     */
    protected $setter;

    /**
     * ClosureBasedDynamicAttribute constructor.
     *
     * @param Closure $getter
     * @param Closure $setter
     */
    public function __construct(Closure $getter, Closure $setter)
    {
        $this->getter = $getter;
        $this->setter = $setter;
    }

    /**
     * Get the given dynamic attribute.
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return ($this->getter)($key);
    }

    /**
     * Set the given dynamic attribute.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        ($this->setter)($key, $value);
    }
}
