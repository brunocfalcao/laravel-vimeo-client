<?php

declare(strict_types=1);

namespace Brunocfalcao\VimeoClient\Facades;

use Illuminate\Support\Facades\Facade;

class VimeoClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'vimeo.client';
    }
}
