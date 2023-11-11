<?php

namespace App\Models;

use App\Scopes\EnableScope;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $supplier_id
 * @property string $name
 * @property integer $document_type
 * @property string $document_number
 * @property string $email
 * @property string $cellphone
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 * @property Supplier $supplier
 */
class SupplierContact extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    
    protected $table = 'supplier_contact';
    
    protected $id = 'id';
    /**
     * @var array
     */
    protected $fillable = ['supplier_id', 'name', 'document_type', 'document_number', 'email', 'cellphone', 'enable', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    protected static function booted()
    {
        static::addGlobalScope(new EnableScope);
    }
}
