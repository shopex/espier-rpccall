<?php
namespace Espier\Rpccall\Servers;

use Espier\Rpccall\Repinterface\Repository;
use Dingo\Api\Routing\Helpers;
use InvalidArgumentException;

class DingoStore implements Repository
{
    use Helpers;

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
        return $this->api->get($uri, $parameters);
    }

    public function post($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->post($uri, $parameters);
    }

    public function put($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->put($uri, $parameters);
    }

    public function delete($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->delete($uri, $parameters);
    }

    public function patch($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->patch($uri, $parameters);
    }

}
