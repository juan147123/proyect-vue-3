<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_dventa
 * @property integer $id_venta
 * @property integer $id_prod
 * @property integer $cantidad
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 * @property Product $product
 * @property Venta $Venta
 */
class DetalleVenta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'detalle_venta';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_dventa';

    /**
     * @var array
     */
    protected $fillable = ['id_venta', 'id_prod', 'cantidad', 'enable', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'id_prod', 'id_prod');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Venta()
    {
        return $this->belongsTo('App\Models\Venta', 'id_venta', 'id_venta');
    }
}
