<?php

namespace Cuongnd88\LaraSimpleDatatable\Facades;

use Illuminate\Support\Facades\Facade;

class SimpleDatatableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
       return 'simpleDatatable';
    }
}
