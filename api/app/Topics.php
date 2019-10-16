<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topics';

    public $incrementing = false;

    public function messages()
    {
        return $this->hasMany('App\Messages');
    }
}