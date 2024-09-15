<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GeneralFacade extends Facade {

    protected static function getFacadeAccessor() { return 'general'; }

}
