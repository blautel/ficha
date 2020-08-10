<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\OwnScope;

class Jornada extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'jornadas';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id', 'user_id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * 1. Global Scope Own (solo puedo ver mis propias jornadas, excepto admin)
     * 2. Observar el evento saving (user_id = backpack_user)
     */
    protected static function booted()
    {
        static::addGlobalScope(new OwnScope);

        static::saving(function ($jornada) {
            $jornada->user_id = backpack_user()->id;
        });
    }

}
