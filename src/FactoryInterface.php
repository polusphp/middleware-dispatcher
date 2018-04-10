<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher;

use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    public function newInstance(): DispatcherInterface;

    public function newConfiguredInstance(?ContainerInterface $container = null): DispatcherInterface;
}