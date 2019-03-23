<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Phone extends Eloquent
{
    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed[]
     */
    protected $fillable = [
        'firstName', 'lastName', 'phones', 'emails',
    ];
}
