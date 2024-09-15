<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Page;
use App\Models\Store\Category;
use App\Models\Store\ProductAttribute;
use App\Models\Store\ProductAttributeValue;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'mag__products';

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

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

    // public function path($active = 1, $access_level = 0)
    // {
    //     if ($this->path != '') {
    //         $path = $this->link . '/' . $this->name;
    //     } else {
    //         $path = $this->name;
    //     }

    //     return $path;
    // }

    // public function link()
    // {
        
    //     $url = $this->path();
    //     if (stripos($url, request()->getHttpHost()) !== false) {
    //         return str_replace(request()->getHttpHost(), '', $url);
    //     }

    //     return  $url;
    // }

    public function breadcrumb()
    {
        $path       = $this->path ? explode('/', $this->path) : null;
        $lastPage   = array();
        $breadcrumb = array();
        if ($path) {
            foreach ($path as $key => $name) {
              $b = implode("/", $lastPage);
                $page = Page::where('name', $name)
                    ->where(function($q) use ($b) {
                      if($b)
                        return $q->where('path', $b);
                      else {
                          return $q->where('path', '')->orWhere('path',null);
                      }
                    })
                    ->where('activ', 1)
                    ->first();
                if ($page) {
                    $breadcrumb[$key]['link']     = '/' . $page->path();
                    $breadcrumb[$key]['showname'] = $page->showname;
                }
                // else {
                //   $categ = Categories::where('name', $name)
                //   ->where('path', count($lastPage) ? implode("/", $lastPage)  : null)
                //   ->where('activ', 1)
                //   ->first();
                //   $breadcrumb[$key]['link'] = '';
                //   $breadcrumb[$key]['showname'] = $categ->title;
                // }
                $lastPage[] = $name;
            }
        }
        $breadcrumb[] = ['link' => '', 'showname' => $this->showname, 'lastItem' => true];

        return $breadcrumb;
    }

    public function scopeActive($query, $activ = '1')
    {
        return $query->where('active', $activ);
    }

    public function scopeSearch($q, $value){
        return $q->where('name', 'LIKE', "%{$value}%")
            ->orWhere('category_id', 'LIKE', "%{$value}%")
            ->orWhere('sku', 'LIKE', "%{$value}%")
            ->orWhere('description', 'LIKE', "%{$value}%")
            ->orWhere('link', 'LIKE', "%{$value}%")
            ->orWhere('code', 'LIKE', "%{$value}%");
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'mag__product_attribute_value', 'product_id', 'attribute_value_id')
            ->with('attribute')
            ->withPivot('price', 'stock', 'images')
            ->withTimestamps();
    }

    // public function attributeValues()
    // {
    //     return $this->belongsToMany(ProductAttributeValue::class, 'mag__product_attribute_value')->withPivot('price', 'image_path');
    // }







    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    public function product_attributes()
    {
        return $this->hasMany(ProductAttributeRows::class);
    }

    public function color()
    {
        return $this->hasMany(ProductAttribute::class, 'id')->where('is_color', 1);
    }

    public function product_attribute()
    {
        return $this->hasOne(ProductAttributeRows::class);
    }

    public function associatedProducts()
    {
        return $this->hasMany(Product::class, 'id', 'associated_products');
    }

    public function getAssociatedProductsAttribute()
    {
        return json_decode($this->attributes['associated_products'], true);
    }
}
