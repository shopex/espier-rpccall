<?php

namespace Espier\Rpccall\Servers;

use Espier\Rpccall\Repinterface\Repository;
use Shopex\TeegonClient\TeegonClient;
use InvalidArgumentException;

class TeegonStore implements Repository
{
    /**
     * teegonclient config.
     *
     * @var array
     */
    public $config;

    /**
     * default header.
     *
     * @var array
     */
    public $defaultHeader;

    public function __construct($config, $defaultHeader)
    {
        $this->config = $config;
        $this->defaultHeader = $defaultHeader;
    }

    public function get($uri, array $parameters = [], array $headers = [])
    {
        return $this->createRequest('get', $uri, $parameters, $headers);
    }

    public function post($uri, array $parameters = [], array $headers = [])
    {
        return $this->createRequest('post', $uri, $parameters, $headers);
    }

    public function put($uri, array $parameters = [], array $headers = [])
    {
        return $this->createRequest('put', $uri, $parameters, $headers);
    }

    public function delete($uri, array $parameters = [], array $headers = [])
    {
        return $this->createRequest('delete', $uri, $parameters, $headers);
    }

    public function patch($uri, array $parameters = [], array $headers = [])
    {
        return $this->createRequest('patch', $uri, $parameters, $headers);
    }

    /**
     * 基于uri和配置向天工开放平台发起REST请求
     *
     * The information contained in the URI always take precedence
     * over the other information (server and parameters).
     *
     * @param string $uri        api名称
     * @param string $method     RESTAPI的请求方法
     * @param array  $parameters 参数
     * @param array  $headers    请求的头信息
     *
     * @return mixed5
     */
    protected function createRequest($verb, $uri, $parameters, $headers)
    {
        $verb    = strtolower($verb);
        if (!$this->config['url'] || !$this->config['key'] || !$this->config['secret']) {
            throw new InvalidArgumentException("TeegonClient paramss url,or key,or secret is not defined.");
        }

        $url     = $this->config['url'];
        $key     = $this->config['key'];
        $secret  = $this->config['secret'];
        $headers = array_merge($this->defaultHeader, $headers);

        // 发起请求
        $client = new TeegonClient($url, $key, $secret, true);
        return $client->$verb($uri, $parameters, $headers);
    }
}
