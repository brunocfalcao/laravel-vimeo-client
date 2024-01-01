<?php

namespace Brunocfalcao\VimeoClient;

use Illuminate\Support\Facades\Facade;

class VimeoClientFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'brunocfalcao-vimeo-client';
    }
}
