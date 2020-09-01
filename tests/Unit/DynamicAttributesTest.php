<?php

namespace PaulhenriL\LaravelDynamicAttributes\Tests\Unit;

use PaulhenriL\LaravelDynamicAttributes\DynamicAttribute;
use PaulhenriL\LaravelDynamicAttributes\Tests\Fakes\Member;
use PaulhenriL\LaravelDynamicAttributes\Tests\TestCase;

class DynamicAttributesTest extends TestCase
{
    public function test_dynamic_attributes_can_be_set_and_get()
    {
        $member = new Member();

        $get = null;
        $set = null;

        $member->registerDynamicAttribute(
            'my_dynamic_attribute',
            function ($key) use (&$get) {
                $get = $key;
            },
            function ($key, $value) use (&$set) {
                $set = [$key => $value];
            }
        );

        $member->my_dynamic_attribute = 'Hello world!';
        $member->my_dynamic_attribute;

        $this->assertEquals('my_dynamic_attribute', $get);
        $this->assertEquals(['my_dynamic_attribute' => 'Hello world!'], $set);
    }

    public function test_dynamic_attributes_closures_are_bound_to_the_model()
    {
        $member = new Member();

        $member->registerDynamicAttribute(
            'my_dynamic_attribute',
            function ($key) {
                return $this->some_attribute;
            },
            function ($key, $value) {
                $this->some_attribute = $value;
            }
        );

        $member->my_dynamic_attribute = 'Hello world!';

        $this->assertEquals('Hello world!', $member->my_dynamic_attribute);
        $this->assertEquals('Hello world!', $member->some_attribute);
    }

    public function test_dynamic_attribute_class()
    {
        $member = new Member();
        $da = new FakeDaClass();
        $member->registerDynamicAttributeClass('hello', $da);

        $member->hello = 'world';
        $member->hello;

        $this->assertEquals('hello', $da->get);
        $this->assertEquals(['hello' => 'world'], $da->set);
    }

    public function test_wildcard_attribute()
    {
        $member = new Member();
        $wildcardAttribute = new WildcardAttribute();
        $member->registerDynamicAttributeClass('prefix_.*', $wildcardAttribute);
        $member->prefix_hello = 'world';
        $member->prefix_foo = 'bar';
        $member->prefix_test = 'value';
        $member->not_prefix_sorry = 'not there';

        $this->assertEquals([
            'prefix_hello' => 'world',
            'prefix_foo' => 'bar',
            'prefix_test' => 'value',
        ], $wildcardAttribute->data);
    }
}

class WildcardAttribute implements DynamicAttribute
{
    public $data = [];

    public function get(string $key)
    {
        return $data[$key] ?? null;
    }

    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }
}

class FakeDaClass implements DynamicAttribute
{
    public $get = null;
    public $set = null;

    public function get(string $key)
    {
        $this->get = $key;
    }

    public function set(string $key, $value): void
    {
        $this->set = [$key => $value];
    }
}
