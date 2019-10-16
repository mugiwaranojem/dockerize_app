<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    public $incrementing = false;
}