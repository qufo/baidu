<?php namespace qufo\Baidu\Facades;

use Illuminate\Support\Facades\Facade;

class Baidu extends Facade {
 
    /**
    * Get the registered name of the component.
    * 
    */
    protected static function getFacadeAccessor(){
        return 'baidu';
    }
}