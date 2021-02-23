<?php


namespace Ouzo\Utilities\Chain;


class EndChain implements Chain
{
    public function proceed(mixed $param): Chain
    {
        return new EndChain();
    }
}