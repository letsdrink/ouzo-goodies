<?php
namespace Ouzo\Utilities\Comparator;

/**
 * Class CompoundComparator
 * @package Ouzo\Utilities\Comparator
 */
class CompoundComparator
{
    /**
     * @var array
     */
    private $comparators;

    public function __construct(array $comparators)
    {
        $this->comparators = $comparators;
    }

    public function __invoke($lhs, $rhs)
    {
        foreach ($this->comparators as $comparator) {
            $result = $comparator($lhs, $rhs);
            if ($result != 0) {
                return $result;
            }
        }
    }
}
