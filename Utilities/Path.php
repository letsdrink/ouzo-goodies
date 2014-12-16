<?php
namespace Ouzo\Utilities;

/**
 * Class Path
 * @package Ouzo\Utilities
 */
class Path
{
    /**
     * Return path for the given arguments.
     *
     * Example:
     * <code>
     * $path = Path::join('/my', 'path', 'to/file.txt');
     * </code>
     * Result:
     * <code>
     * /my/path/to/file.txt
     * </code>
     *
     * @param string ...
     * @return mixed
     */
    public static function join()
    {
        $args = Arrays::filterNotBlank(func_get_args());
        return preg_replace('~[/\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $args));
    }

    /**
     * Return path staring in system temporary directory.
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
     *
     * @param string ...
     * @return mixed
     */
    public static function joinWithTemp()
    {
        $args = array_merge(array(sys_get_temp_dir()), func_get_args());
        return call_user_func_array('\Ouzo\Utilities\Path::join', $args);
    }

    /**
     * Return normalized path.
     * Actions:
     * <ul>
     *      <li>removes dots from relative path</li>
     *      <li>removes dots from absolute path</li>
     *      <li>not remove leading dots</li>
     *      <li>remove double slashes</li>
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
     *
     * @param string $path
     * @return string
     */
    public static function normalize($path)
    {
        $parts = explode('/', trim($path, '/'));
        $result = array();
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
