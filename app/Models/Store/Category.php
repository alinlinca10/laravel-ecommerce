<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'categories';

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function imgs()
    {
        if ($this->pictures) {
            return unserialize($this->pictures);
        } else {
            return null;
        }
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

}
