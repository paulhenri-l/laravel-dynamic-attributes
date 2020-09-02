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
    public function getAttribute($key)
    {
        if ($da = $this->getDynamicAttributeClass($key)) {
            return $da->get($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Call the dynamic attribute setter if there is one or pass to the parent.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($da = $this->getDynamicAttributeClass($key)) {
            $da->set($key, $value);

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Return the dynamic attribute class.
     *
     * @param string $key
     * @return DynamicAttribute|null
     */
    protected function getDynamicAttributeClass(string $key): ?DynamicAttribute
    {
        return $this->dynamicAttributes[$key] ?? null;
    }
}
