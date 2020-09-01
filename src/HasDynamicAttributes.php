<?php

namespace PaulhenriL\LaravelDynamicAttributes;

use Closure;

trait HasDynamicAttributes
{
    /**
     * The list of dynamic attributes.
     *
     * @var DynamicAttribute[]
     */
    protected $dynamicAttributes = [];

    /**
     * Keep a cached array of previously matched attributes. So that we don't
     * run a preg match on every get and set call.
     *
     * @var ?string[]
     */
    protected $previousMatches = [];

    /**
     * Register a dynamic attribute.
     *
     * @param string $key
     * @param Closure $getter
     * @param Closure $setter
     */
    public function registerDynamicAttribute(string $key, Closure $getter, Closure $setter)
    {
        $this->registerDynamicAttributeClass($key, new ClosureBasedDynamicAttribute(
            $getter->bindTo($this),
            $setter->bindTo($this)
        ));
    }

    /**
     * Register the given dynamic attribute class.
     *
     * @param string $key
     * @param DynamicAttribute $dynamicAttribute
     */
    public function registerDynamicAttributeClass(string $key, DynamicAttribute $dynamicAttribute)
    {
        $this->dynamicAttributes[$key] = $dynamicAttribute;
    }

    /**
     * Call the dynamic attribute getter if there is one or pass to the parent.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($daKey = $this->getDynamicAttributeKey($key)) {
            return $this->dynamicAttributes[$daKey]->get($key);
        }

        return parent::__get($key);
    }

    /**
     * Call the dynamic attribute setter if there is one or pass to the parent.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        if ($daKey = $this->getDynamicAttributeKey($key)) {
            $this->dynamicAttributes[$daKey]->set($key, $value);
            return;
        }

        parent::__set($key, $value);
    }

    /**
     * Flush the cache of previously matched dynamic attribute keys.
     */
    public function flushDynamicAttributeKeyCache()
    {
        $this->previousMatches = [];
    }

    /**
     * Check if the given key matches with a dynamic attribute.
     */
    protected function getDynamicAttributeKey(string $key): ?string
    {
        $cache = $this->previousMatches;

        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $daKey = array_filter(array_keys($this->dynamicAttributes), function ($da) use ($key) {
            return preg_match('/^' . $da . '$/', $key);
        });

        $result = $cache[$key] = array_shift($daKey);

        return $result;
    }
}
