<?php namespace Satudata\Lpeprovinsi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Lpeprovinsi facade.
 *
 * @package Satudata\Lpeprovinsi
 * @author  MKI <info@mkitech.net>
 */
class Lpeprovinsi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lpeprovinsi';
    }
}
