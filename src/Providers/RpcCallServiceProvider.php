<?php
namespace Espier\Rpccall\Providers;

use Illuminate\Support\ServiceProvider;
use Espier\Rpccall\Rpccall;
use Espier\Rpccall\Servers\Teegon;

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
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/rpccall.php'), 'rpccall');
        $this->app->singleton('rpccall', function () {
            return new Rpccall(new Teegon());
        });
        // $this->app->bind('rpccall', 'Espier\Rpccall\Rpccall');

        // $this->app->bind('Rpccall',function(){
        //     return new Rpccall();
        // });
    }
}
