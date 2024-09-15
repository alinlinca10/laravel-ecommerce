<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Store\Category;
use App\Models\Store\ProductAttributeValue;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'mag__attributes';

    public function imgs()
    {
        if ($this->pictures) {
            return unserialize($this->pictures);
        } else {
            return null;
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeActive($query, $activ = '1')
    {
        return $query->where('active', $activ);
    }

    public function scopeSearch($q, $value){
        return $q->where('name', 'LIKE', "%{$value}%")
            ->orWhere('id', 'LIKE', "%{$value}%");
    }

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }
}
