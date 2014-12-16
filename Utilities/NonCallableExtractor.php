<?php
namespace Ouzo\Utilities;

use InvalidArgumentException;

class NonCallableExtractor
{
    public function __construct()
    {
        $this->extractor = new Extractor();
    }

    public function __get($field)
    {
        $this->extractor->__get($field);
        return $this->extractor;
    }

    public function __call($name, $arguments)
    {
        $this->extractor->__call($name, $arguments);
        return $this->extractor;
    }

    public function __invoke($input)
    {
        throw new InvalidArgumentException("Empty Extractor cannot be invoked!");
    }
}
