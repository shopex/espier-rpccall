<?php

namespace Espier\Rpccall\Contracts;

interface Factory
{
    /**
     * Get a rpclient store instance by name.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function store($name = null);
}
