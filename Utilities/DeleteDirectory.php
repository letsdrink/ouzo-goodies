<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class DeleteDirectory
{
    /** Recursively deletes directories and files. */
    public static function recursive(string $path): void
    {
        if (is_dir($path)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($iterator as $file) {
                self::deleteFile($file);
            }
            rmdir($path);
        }
    }

    private static function deleteFile(SplFileInfo $file): void
    {
        if (in_array($file->getBasename(), ['.', '..'])) {
            return;
        }
        if ($file->isDir()) {
            rmdir($file->getPathname());
        } elseif ($file->isFile() || $file->isLink()) {
            unlink($file->getPathname());
        }
    }
}
