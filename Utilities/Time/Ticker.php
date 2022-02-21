<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities\Time;

class Ticker
{
    public function read(): int
    {
        return intval(microtime(true) * 1000 * 1000 * 1000);
    }
}
