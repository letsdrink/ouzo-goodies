<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

class Path
{
    /**
     * Returns a path created by placing DIRECTORY_SEPARATOR between each argument
     *
     * Example:
     * <code>
     * $path = Path::join('/my', 'path', 'to/file.txt');
     * </code>
     * Result:
     * <code>
     * /my/path/to/file.txt
     * </code>
     */
    public static function join(string ...$args): string
    {
        $args = Arrays::filterNotBlank($args);
        $path = preg_replace('~[/\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $args));
        $path = str_replace("\0", '', $path);
        return $path;
    }

    /**
     * Returns a path starting in the system temporary directory.
     *
     * Example:
     * <code>
     * $path = Path::joinWithTemp('my/file.txt');
     * </code>
     * Result:
     * <code>
     * //Unix
     * /tmp/my/file.txt
     * </code>
     */
    public static function joinWithTemp(string ...$args): string
    {
        return Path::join(sys_get_temp_dir(), ...$args);
    }

    /**
     * Returns a normalized path.
     * Actions:
     * <ul>
     *      <li>removes dots from relative path</li>
     *      <li>removes dots from absolute path</li>
     *      <li>does not remove leading dots</li>
     *      <li>removes double slashes</li>
     * </ul>
     *
     * Example:
     * <code>
     * $normalized = Path::normalize('dir/../dir2/file.txt');
     * $normalized = Path::normalize('/tmp/../dir2/file.txt');
     * $normalized = Path::normalize('../file.txt');
     * $normalized = Path::normalize('//dir/file.txt');
     * </code>
     * Result:
     * <code>
     * dir2/file.txt
     * /dir2/file.txt
     * ../file.txt
     * /dir/file.txt
     * </code>
     */
    public static function normalize(string $path): string
    {
        $parts = explode('/', trim($path, '/'));
        $result = [];
        foreach ($parts as $part) {
            if ($part == '..' && !empty($result)) {
                array_pop($result);
            } elseif ($part != '.' && !empty($part)) {
                array_push($result, $part);
            }
        }
        $root = $path[0] == '/' ? '/' : '';
        return $root . implode('/', $result);
    }
}
