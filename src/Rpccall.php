<?php

namespace Espier\Rpccall;

use Espier\Rpccall\Repinterface\Repository as ApiServer;

class Rpccall
{
    /**
     * Version for the request.
     *
     * @var string
     */
    protected $version;

    /**
     * Request headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Request parameters.
     *
     * @var array
     */
    protected $parameters = [];

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
     * Default version.
     *
     * @var string
     */
    protected $defaultVersion;

    /**
     * apiserver.
     *
     * @var string
     */
    protected $apiserver;


    /**
     * Create a new dispatcher instance.
     *
     * @param \Illuminate\Container\Container   $container
     *
     * @return void
     */
    public function __construct(ApiServer $apiserver)
    {
        $this->apiserver = $apiserver;
    }

    public function get($uri, $parameters, $headers)
    {
        return $this->apiserver->get($uri, $parameters, $headers);
    }

    public function post($uri, $parameters, $headers)
    {
        return $this->apiserver->post($uri, $parameters, $headers);
    }

    public function put($uri, $parameters, $headers)
    {
        return $this->apiserver->put($uri, $parameters, $headers);
    }

    public function delete($uri, $parameters, $headers)
    {
        return $this->apiserver->delete($uri, $parameters, $headers);
    }

    public function patch($uri, $parameters, $headers)
    {
        return $this->apiserver->patch($uri, $parameters, $headers);
    }

    /**
     * Set the version of the API for the next request.
     *
     * @param string $version
     *
     * @return \Dingo\Api\Dispatcher
     */
    public function version($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Set a header to be sent on the next API request.
     *
     * @param string $key
     * @param string $value
     *
     * @return \Dingo\Api\Dispatcher
     */
    public function header($key, $value)
    {
        $this->headers[$key] = $value;

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
}
