<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */
namespace Ouzo\Utilities;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class DeleteDirectory
 * @package Ouzo\Utilities
 */
class DeleteDirectory
{
    /**
     * Recursively deletes directories and files.
     *
     * @param string $path
     */
    public static function recursive($path)
    {
        if (is_dir($path)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($iterator as $file) {
                self::_deleteFile($file);
            }
            rmdir($path);
        }
    }

    private static function _deleteFile(SplFileInfo $file)
    {
        if (in_array($file->getBasename(), ['.', '..'])) {
            return;
        } elseif ($file->isDir()) {
            rmdir($file->getPathname());
        } elseif ($file->isFile() || $file->isLink()) {
            unlink($file->getPathname());
        }
    }
}
