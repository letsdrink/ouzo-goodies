<?php
namespace Ouzo\Utilities\Comparator;

class ReversedComparator
{
    private $comparator;

    public function __construct($comparator)
    {
        $this->comparator = $comparator;
    }

    public function __invoke($lhs, $rhs)
    {
        $comparator = $this->comparator;
        return -1 * $comparator($lhs, $rhs);
    }
}
