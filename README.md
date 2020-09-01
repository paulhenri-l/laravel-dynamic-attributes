# Laravel Dynamic Attributes

![Tests](https://github.com/paulhenri-l/laravel-dynamic-attributes/workflows/Tests/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

Allow you to dynamically add attributes to your eloquent models at runtime.

## Installation

```
composer require paulhenri-l/laravel-dynamic-attributes
```

## Usage

You'll first need to add the `HasDynamicAttributesTrait` to your model.

```php
class Member extends Illuminate\Database\Eloquent\Model
{
    use PaulhenriL\LaravelDynamicAttributes\HasDynamicAttributes;
}
```

Then you can register dynamic fields from your constructor or any other place 
that will get called at runtime.

A good place for that is from the initialize method of a trait.

```php
class Member extends Illuminate\Database\Eloquent\Model
{
    use PaulhenriL\LaravelDynamicAttributes\HasDynamicAttributes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->registerDynamicAttribute(
            'my_dynamic_attribute',
            function ($key) {
                return "Trying to get {$key}";
            },
            function ($key, $value) {
                echo "Setting {$key}";
            }
        );
    }
}
```

You can now set and get from your dynamic attribute:

```
$member = new Member();
$member->my_dynamic_attribute = 'Hello';
$member->my_dynamuc_attribute;
```

## Contributing

If you have any questions on how to use this library feel free to open an
issue.

If you think that the documentation or the code could be improved in any way
open a PR and I'll happily review it!
