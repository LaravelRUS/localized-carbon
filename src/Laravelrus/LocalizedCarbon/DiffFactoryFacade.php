<?php

namespace Laravelrus\LocalizedCarbon;


use Illuminate\Support\Facades\Facade;

class DiffFactoryFacade extends Facade{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'difffactory'; }
} 
