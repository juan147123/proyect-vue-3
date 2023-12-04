<?php

namespace App\Models;

use App\Scopes\EnableScope;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $descripcion
 * @property string $uso
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 */
class Tipos extends Model
{
    /**
     * @var array
     */
    protected $id = 'id';
    
    protected $fillable = ['parent_id', 'descripcion', 'uso', 'enable', 'created_at', 'updated_at'];

    protected static function booted()
    {
        static::addGlobalScope(new EnableScope);
    }
}
