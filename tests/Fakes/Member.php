<?php

namespace PaulhenriL\LaravelDynamicAttributes\Tests\Fakes;

use Illuminate\Database\Eloquent\Model;
use PaulhenriL\LaravelDynamicAttributes\HasDynamicAttributes;

class Member extends Model
{
    use HasDynamicAttributes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
