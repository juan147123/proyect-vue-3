<?php

namespace App\Models;

use App\Scopes\EnableScope;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $business_name
 * @property integer $document_type
 * @property string $document_number
 * @property string $address
 * @property string $email
 * @property integer $enable
 * @property string $created_at
 * @property string $updated_at
 * @property SupplierContact[] $supplierContacts
 */
class Supplier extends Model
{
    /**
     * @var array
     */
    protected $id = 'id';
    
    protected $fillable = ['business_name', 'document_type', 'document_number', 'address', 'email', 'enable', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supplierContacts()
    {
        return $this->hasMany('App\Models\SupplierContact');
    }

    protected static function booted()
    {
        static::addGlobalScope(new EnableScope);
    }
}
