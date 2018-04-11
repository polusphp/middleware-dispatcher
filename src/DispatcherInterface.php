<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface DispatcherInterface
{
    const DEFAULT_PRIORITY = 1000;

    public function addMiddlewares(array $middlewares);

    public function addMiddleware(MiddlewareInterface $middleware, int $priority = self::DEFAULT_PRIORITY);

    public function dispatch(ServerRequestInterface $request): ResponseInterface;
}
