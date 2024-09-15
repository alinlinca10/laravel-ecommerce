<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Product;
use App\Models\User;
use App\Models\Store\Category;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'pages';

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id');
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
            ->orWhere('category_id', 'LIKE', "%{$value}%")
            ->orWhere('description', 'LIKE', "%{$value}%")
            ->orWhere('path', 'LIKE', "%{$value}%");
    }

    protected static function getOnePage($name, $path = '', $active = 1)
    {
        // dd(Page::where('name', $name)->first());
        return Page::where('name', $name)
            // ->where(function($q) use ($path) {
            //   if($path)
            //     return $q->where('path', $path);
            //   else {
            //     return $q->where('path', '')->orWhere('path',null);
            //   }
            // })
            ->where('active', $active)
            // ->with(['widgets', 'content'])
            ->first();
    }
    public static function homepage() {
    //   if($homepage = Settings::get('homepage'))
    //     return $homepage;
    if($homepage = 'acasa')
        return $homepage;
      elseif($page = Page::where('path', '')->orWhere('path', null)->first())
        return $page->name;
      else
        return '';
    }

    public function path($active = 1, $access_level = 0)
    {
        if ($this->path != '') {
            $path = $this->path . '/' . $this->name;
        } else {
            $path = $this->name;
        }

        return $path;
    }

    public function link()
    {
        $url = $this->path();
        if (stripos($url, request()->getHttpHost()) !== false) {
            return str_replace(request()->getHttpHost(), '', $url);
        }

        return  $url;
    }

    public static function makeName($showname)
    {
        return str_replace(' ', '-', strtolower($showname));
    }

    public static function makeKeywords($showname)
    {
        return str_replace(' ', ',', trim($showname));
    }

    public static function makePath($category = null)
    {
        return $category ? ($category->path ? $category->path . '/' . $category->name : $category->name) : '';
    }

}
