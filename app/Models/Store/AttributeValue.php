<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Store\ProductAttribute;

class AttributeValue extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'mag__attribute_values';

    public function imgs()
    {
        if ($this->pictures) {
            return unserialize($this->pictures);
        } else {
            return null;
        }
    }

    public function scopeActive($query, $activ = '1')
    {
        return $query->where('active', $activ);
    }

    public function scopeSearch($q, $value){
        return $q->where('name', 'LIKE', "%{$value}%");
    }

    // public function attribute()
    // {
    //     return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    // }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'mag__product_attribute_value.product_attribute_value_id')->withPivot('price', 'image_path');
    }
}
