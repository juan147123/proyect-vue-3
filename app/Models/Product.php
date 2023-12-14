<?php

namespace App\Models;

use App\Scopes\EnableScope;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_prod
 * @property integer $id_supp
 * @property string $codigoProd
 * @property integer $idTipoProducto
 * @property integer $idTipoUnidadMedida
 * @property float $precioCompra
 * @property integer $porcentaje
 * @property float $precioVenta
 * @property integer $stock
 * @property string $estado
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 * @property DetalleVentum[] $detalleVentas
 * @property Inoutproduct[] $inoutproducts
 * @property Supplier $supplier
 * @property Tipo $tipo
 * @property Tipo $tipo
 */
class Product extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_prod';

    /**
     * @var array
     */
    protected $fillable = ['id_supp', 'codigoProd', 'idTipoProducto', 'idTipoUnidadMedida', 'precioCompra', 'porcentaje', 'precioVenta', 'stock', 'estado', 'enable', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalleVentas()
    {
        return $this->hasMany('App\Models\DetalleVenta', 'id_prod', 'id_prod');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inoutproducts()
    {
        return $this->hasMany('App\Models\Inoutproduct', 'id_prod', 'id_prod');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'id_supp');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productsTipo()
    {
        return $this->belongsTo('App\Models\Tipos', 'idTipoProducto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productsUM()
    {
        return $this->belongsTo('App\Models\Tipos', 'idTipoUnidadMedida');
    }
    
    protected static function booted()
    {
        static::addGlobalScope(new EnableScope);
    }
}
