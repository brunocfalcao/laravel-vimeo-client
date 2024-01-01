<?php

namespace Brunocfalcao\VimeoClient;

use Brunocfalcao\VimeoClient\VimeoClient;
use Illuminate\Support\ServiceProvider;

class VimeoClientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind('brunocfalcao-vimeo-client', function () {
            return new VimeoClient();
        });
    }
}
