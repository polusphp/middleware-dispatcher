<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher;

use Interop\Http\Factory\ResponseFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;

abstract class AbstractDispatcher implements DispatcherInterface
{
    /** @var PriorityQueue */
    protected $middlewares;

    /** @var ResponseFactoryInterface */
    protected $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->middlewares = new PriorityQueue();
        $this->responseFactory = $responseFactory;
    }

    public function addMiddlewares(array $middlewares)
    {
        foreach ($middlewares as &$middleware) {
            $this->middlewares->insert($middleware, self::DEFAULT_PRIORITY);
        }
    }

    public function addMiddleware(MiddlewareInterface $middleware, int $priority = self::DEFAULT_PRIORITY)
    {
        $this->middlewares->insert($middleware, $priority);
    }
    
    public function __clone()
    {
        $this->middlewares = clone $this->middlewares;
    }
}
