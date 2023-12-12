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
 * @property Product[] $products
 * @property Product[] $products
 */
class Tipos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['parent_id', 'descripcion', 'uso', 'enable', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsTipo()
    {
        return $this->hasMany('App\Models\Product', 'idTipoProducto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productsUM()
    {
        return $this->hasMany('App\Models\Product', 'idTipoUnidadMedida');
    }
    protected static function booted()
    {
        static::addGlobalScope(new EnableScope);
    }
}
