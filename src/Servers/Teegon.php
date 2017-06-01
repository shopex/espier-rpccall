<?php

namespace Espier\Rpccall\Servers;

use Espier\Rpccall\Repinterface\Repository;

include __DIR__ . "/../../../../shopex/teegon/src/TeegonClient.php";
use TeegonClient;

class Teegon implements Repository
{

    public function __construct($connection)
    {
        $this->connection = $connection;
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
    protected static function createRequest($verb, $uri, $parameters, $headers)
    {
        $verb   = strtolower($verb);
        $url    = 'http://api.teegon.com/router';
        // $url    = 'http://127.0.0.1/espier/public/index.php/api/test2';
        $key    = '47b7QcS';
        $secret = 'ZmXxR5PXXEz8mjCwary4';

        // 发起请求
        $client = new TeegonClient($url, $key, $secret);
        // echo "<pre>";print_r($uri);exit;
        return $client->$verb($uri, $parameters, $headers);
    }
}
