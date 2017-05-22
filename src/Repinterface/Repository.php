<?php

namespace Espier\Rpccall\Repinterface;

interface Repository
{
    /**
     * 注册一个 GET 请求方法.
     *
     * @param  string  $uri
     * @param  array   $action
     * @param  array   $headers
     * @return void
     */
    public function get($uri, array $parameters = [], array $headers = []);

    /**
     * 注册一个 POST 请求方法.
     *
     * @param  string  $uri
     * @param  array   $action
     * @param  array   $headers
     * @return void
     */
    public function post($uri, array $parameters = [], array $headers = []);

    /**
     * 注册一个 PUT 请求方法.
     *
     * @param  string  $uri
     * @param  array   $action
     * @param  array   $headers
     * @return void
     */
    public function put($uri, array $parameters = [], array $headers = []);

    /**
     * 注册一个 DELETE 请求方法.
     *
     * @param  string  $uri
     * @param  array   $action
     * @param  array   $headers
     * @return void
     */
    public function delete($uri, array $parameters = [], array $headers = []);

    /**
     * 注册一个 PATCH 请求方法.
     *
     * @param  string  $uri
     * @param  array   $action
     * @param  array   $headers
     * @return void
     */
    public function patch($uri, array $parameters = [], array $headers = []);
}
