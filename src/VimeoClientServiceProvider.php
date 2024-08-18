<?php

declare(strict_types=1);

namespace Brunocfalcao\VimeoClient;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use VimeoClient as Vimeo;

class VimeoClientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setupConfig();
    }

    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    public function provides(): array
    {
        return [
            'vimeo.client',
            'vimeo.factory',
            'vimeo.connection',
        ];
    }

    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/vimeo.php');

        if (! $source) {
            throw new \UnexpectedValueException('Could not locate config');
        }

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('vimeo.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('vimeo');
        }

        $this->mergeConfigFrom($source, 'vimeo');
    }

    protected function registerFactory()
    {
        $this->app->singleton('vimeo.factory', function (): VimeoFactory {
            return new VimeoFactory;
        });

        $this->app->alias('vimeo.factory', VimeoFactory::class);
    }

    protected function registerManager()
    {
        $this->app->singleton('vimeo.client', function (Container $app): VimeoManager {
            /** @var \Illuminate\Contracts\Config\Repository */
            $config = $app['config'];
            /** @var VimeoFactory */
            $factory = $app['vimeo.factory'];

            return new VimeoManager($config, $factory);
        });

        $this->app->alias('vimeo.client', VimeoManager::class);
    }

    protected function registerBindings()
    {
        $this->app->bind('vimeo.connection', function (Container $app): Vimeo {
            /** @var VimeoManager */
            $manager = $app['vimeo.client'];

            /** @var Vimeo */
            return $manager->connection();
        });

        $this->app->alias('vimeo.connection', Vimeo::class);
    }
}
