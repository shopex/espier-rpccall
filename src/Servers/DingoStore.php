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
        return $this->api->raw()->get($uri, $parameters)->content();
    }

    public function post($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->raw()->post($uri, $parameters)->content();
    }

    public function put($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->raw()->put($uri, $parameters)->content();
    }

    public function delete($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->raw()->delete($uri, $parameters)->content();
    }

    public function patch($uri, array $parameters = [], array $headers = [])
    {
        return $this->api->raw()->patch($uri, $parameters)->content();
    }

}
