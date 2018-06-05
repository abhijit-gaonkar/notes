<?php

namespace Notes\Core\Models;

use Psr\Container\ContainerInterface;

abstract class AbstractModel
{
    /**
     * @param ContainerInterface $container
     */
    final public function __construct(ContainerInterface $container)
    {
        $this->di = $container;
    }
}