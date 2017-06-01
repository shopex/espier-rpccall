<?php

namespace Espier\Rpccall;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Espier\Rpccall\Contracts\Store;
use Espier\Rpccall\Contracts\Factory as FactoryContract;
use Espier\Rpccall\Servers\TeegonStore;

class RpccallManager implements FactoryContract
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved rpcclient stores.
     *
     * @var array
     */
    protected $stores = [];

    /**
     * Create a new rpcclient manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a rpcclient store instance by name.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function store($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->stores[$name] = $this->get($name);
    }

    /**
     * Get a rpcclient driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        return $this->store($driver);
    }

    /**
     * Attempt to get the store from the local rpcclient.
     *
     * @param  string  $name
     * @return object
     */
    protected function get($name)
    {
        return isset($this->stores[$name]) ? $this->stores[$name] : $this->resolve($name);
    }

    /**
     * Resolve the given store.
     *
     * @param  string  $name
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        if (is_null($config)) {
            throw new InvalidArgumentException("Rpcclient store [{$name}] is not defined.");
        }

        $driverMethod = 'create'.ucfirst($config['driver']).'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        } else {
            throw new InvalidArgumentException("Rpcclient Driver [{$config['driver']}] is not supported.");
        }
    }

    /**
     * Create an instance of the Redis rpcclient driver.
     *
     * @param  array  $config
     * @return teegonstore objecjt instance
     */
    protected function createTeegonDriver(array $config)
    {
        return new TeegonStore($config);
    }

    /**
     * Get the rpcclient connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["rpcclient.stores.{$name}"];
    }

    /**
     * Get the default rpcclient driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['rpcclient.default'];
    }

    /**
     * Set the default rpcclient driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['rpcclient.default'] = $name;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->store()->$method(...$parameters);
    }
}
