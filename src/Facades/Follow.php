<?php
namespace Wimil\Followers\Facades;

use Illuminate\Support\Facades\Facade;

class Follow extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'follow';
    }
}
