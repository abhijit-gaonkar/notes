<?php

namespace Notes\Core\Controllers;

use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @param ContainerInterface $container
     */
    final public function __construct(ContainerInterface $container)
    {
        $this->di = $container;
    }
}