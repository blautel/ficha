<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

use App\Scopes\OwnScope;
use Carbon\Carbon;

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
    protected $dates = [
        'final',
    ];
    public $appends = ['nombre', 'duracion'];

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
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
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
        static::updating(function ($jornada) {
            $jornada->final ?: $jornada->final = Carbon::now();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getNombreAttribute()
    {
        return $this->user->name;
    }

    public function getDuracionAttribute()
    {
        return $this->final
            ? $this->final->diffAsCarbonInterval($this->created_at)->roundMinute()->forHumans()
            : Carbon::now()->diffAsCarbonInterval($this->created_at)->roundMinute()->forHumans();
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
