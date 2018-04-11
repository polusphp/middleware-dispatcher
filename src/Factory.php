<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher;

use Psr\Container\ContainerInterface;

class Factory implements FactoryInterface
{
    /** @var DispatcherInterface */
    private $middlewareDispatcher;
    /** @var ContainerInterface */
    private $container;
    /** @var array|iterable */
    private $middlewares = [];

    /**
     * MiddlewareFactory constructor.
     * @param DispatcherInterface $dispatcher
     * @param ContainerInterface|iterable $container Psr-11 container or iterable list of middlewares
     */
    public function __construct(DispatcherInterface $dispatcher, $container)
    {
        $this->middlewareDispatcher = $dispatcher;
        if ($container instanceof ContainerInterface) {
            $this->container = $container;
        } elseif (is_iterable($container)) {
            if ($container instanceof \Traversable) {
                $this->middlewares = iterator_to_array($container);
            } else {
                $this->middlewares = $container;
            }
        }
    }

    public function newInstance(): DispatcherInterface
    {
        return clone $this->middlewareDispatcher;
    }

    public function newConfiguredInstance(?ContainerInterface $container = null): DispatcherInterface
    {
        if (is_null($container)) {
            $container = $this->container;
        }

        $dispatcher = clone $this->middlewareDispatcher;
        $middlewares = [];
        if ($container && $container->has('polus/adr:middlewares')) {
            $middlewares = $container->get('polus/adr:middlewares');
        } elseif (count($this->middlewares)) {
            $middlewares = $this->middlewares;
        }
        $dispatcher->setMiddlewares($middlewares);
        return $dispatcher;
    }
}
