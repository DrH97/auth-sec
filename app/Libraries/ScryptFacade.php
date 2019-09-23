<?php
namespace Scrypt;
use Illuminate\Support\Facades\Facade;
/**
 * @see \Collective\Html\HtmlBuilder
 */
class ScryptFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return '\Scrypt\ScryptHash';
    }
}