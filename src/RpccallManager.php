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
     * Version for the request.
     *
     * @var string
     */
    protected $version;

    /**
     * Domain for the request.
     *
     * @var string
     */
    protected $domain;

    /**
     * API subtype.
     *
     * @var string
     */
    protected $subtype;

    /**
     * API standards tree.
     *
     * @var string
     */
    protected $standardsTree;

    /**
     * API prefix.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Default version.
     *
     * @var string
     */
    protected $defaultVersion;

    /**
     * Default domain.
     *
     * @var string
     */
    protected $defaultDomain;

    /**
     * Default format.
     *
     * @var string
     */
    protected $defaultFormat;

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
        $defaultHeader = ['host'=>$this->getDomain(),'accept'=>$this->getAcceptHeader()];
        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config, $defaultHeader);
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
    protected function createTeegonDriver(array $config, array $defaultHeader)
    {
        return new TeegonStore($config, $defaultHeader);
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
     * Set the version of the API for the next request.
     *
     * @param string $version
     *
     * @return string
     */
    public function version($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Build the "Accept" header.
     *
     * @return string
     */
    protected function getAcceptHeader()
    {
        return sprintf('application/%s.%s.%s+%s', $this->getStandardsTree(), $this->getSubtype(), $this->getVersion(), $this->getFormat());
    }

    /**
     * Get the domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain ?: $this->defaultDomain;
    }

    /**
     * Get the version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version ?: $this->defaultVersion;
    }

    /**
     * Get the format.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->defaultFormat;
    }

    /**
     * Get the subtype.
     *
     * @return string
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * Set the subtype.
     *
     * @param string $subtype
     *
     * @return void
     */
    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;
    }

    /**
     * Get the standards tree.
     *
     * @return string
     */
    public function getStandardsTree()
    {
        return $this->standardsTree;
    }

    /**
     * Set the standards tree.
     *
     * @param string $standardsTree
     *
     * @return void
     */
    public function setStandardsTree($standardsTree)
    {
        $this->standardsTree = $standardsTree;
    }

    /**
     * Set the prefix.
     *
     * @param string $prefix
     *
     * @return void
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Set the default version.
     *
     * @param string $version
     *
     * @return void
     */
    public function setDefaultVersion($version)
    {
        $this->defaultVersion = $version;
    }

    /**
     * Set the default domain.
     *
     * @param string $domain
     *
     * @return void
     */
    public function setDefaultDomain($domain)
    {
        $this->defaultDomain = $domain;
    }

    /**
     * Set the defult format.
     *
     * @param string $format
     *
     * @return void
     */
    public function setDefaultFormat($format)
    {
        $this->defaultFormat = $format;
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
