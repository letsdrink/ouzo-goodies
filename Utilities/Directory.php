<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class Directory
 * @package Ouzo\Utilities
 */
class Directory
{
    public static function size($path)
    {
        $total = 0;
        $path = realpath($path);
        if ($path !== false) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $total += $object->getSize();
            }
        }
        return $total;
    }
}
