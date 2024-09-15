<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table   = 'country';
    protected $guarded = ['_token'];

    public static function phonecode() {
        $code =  Country::select('name','phonecode')->get();

        return $code;
    }
}
