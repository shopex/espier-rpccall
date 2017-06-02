<?php
namespace Espier\Rpccall\Providers;

use Illuminate\Support\ServiceProvider;
// use Espier\Rpccall\Rpccall;
// use Espier\Rpccall\Servers\Teegon;
use Espier\Rpccall\RpccallManager;

class RpcCallServiceProvider extends ServiceProvider
{

    /**
     * boot process
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //加载config
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/rpcclient.php'), 'rpcclient');

        $this->app->singleton('rpccall', function ($app) {
            $manager = new RpccallManager($app);

            $manager->setSubtype($this->app['config']['api.subtype']);
            $manager->setStandardsTree($this->app['config']['api.standardsTree']);
            // $manager->setPrefix($this->app['config']['api.prefix']);
            $manager->setDefaultVersion($this->app['config']['api.version']);
            $manager->setDefaultDomain($this->app['config']['api.domain']);
            $manager->setDefaultFormat($this->app['config']['api.defaultFormat']);

            return $manager;
        });
    }
}
