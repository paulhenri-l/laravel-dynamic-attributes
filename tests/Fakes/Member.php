<?php

namespace PaulhenriL\LaravelDynamicAttributes\Tests\Fakes;

use Illuminate\Database\Eloquent\Model;
use PaulhenriL\LaravelDynamicAttributes\HasDynamicAttributes;

class Member extends Model
{
    use HasDynamicAttributes;
}
