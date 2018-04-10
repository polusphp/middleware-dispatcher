<?php
declare(strict_types=1);

namespace Polus\MiddlewareDispatcher;

use Psr\Http\Server\MiddlewareInterface;

class PriorityQueue implements \Countable, \IteratorAggregate
{
    protected $queueOrder = PHP_INT_MAX;
    protected $innerQueue;
    
    public function __construct()
    {
        $this->innerQueue = new \SplPriorityQueue;
    }

    public function count()
    {
        return count($this->innerQueue);
    }

    public function insert(MiddlewareInterface $middleware, int $priority)
    {
        $this->innerQueue->insert($middleware, [$priority, $this->queueOrder--]);
    }
    
    public function getIterator()
    {
        return clone $this->innerQueue;
    }

    public function toArray()
    {
		return iterator_to_array($this->getIterator());
    }
}