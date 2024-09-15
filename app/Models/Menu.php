<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'menus';

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
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('categories');
    }

}
