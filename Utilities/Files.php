<?php
namespace Ouzo\Utilities;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * Class Files
 * @package Ouzo\Utilities
 */
class Files
{
    /**
     * Load file using require or require_once if the $loadOnce flag is set to true.
     *
     * @param string $path
     * @param bool $loadOnce
     * @return bool
     */
    public static function loadIfExists($path, $loadOnce = true)
    {
        if (self::exists($path)) {
            self::_require($path, $loadOnce);
            return true;
        }
        return false;
    }

    /**
     * Load file using require or require_once if the $loadOnce flag is set to true, if file is not exists throw FileNotFoundException.
     *
     * @param string $path
     * @param bool $loadOnce
     * @throws FileNotFoundException
     */
    public static function load($path, $loadOnce = true)
    {
        if (!self::loadIfExists($path, $loadOnce)) {
            throw new FileNotFoundException('Cannot load file: ' . $path);
        }
    }

    private static function _require($path, $loadOnce)
    {
        if ($loadOnce) {
            /** @noinspection PhpIncludeInspection */
            require_once($path);
        } else {
            /** @noinspection PhpIncludeInspection */
            require($path);
        }
    }

    /**
     * Delete file, if not exists throw FileNotFoundException.
     *
     * @param string $path
     * @return bool
     * @throws FileNotFoundException
     */
    public static function delete($path)
    {
        if (!self::exists($path)) {
            throw new FileNotFoundException('Cannot find file: ' . $path);
        }
        return unlink($path);
    }

    /**
     * Move file from the source to the destination path, if source file is not exists throw FileNotFoundException.
     *
     * @param string $sourcePath
     * @param string $destinationPath
     * @return bool
     * @throws FileNotFoundException
     */
    public static function move($sourcePath, $destinationPath)
    {
        if (!self::exists($sourcePath)) {
            throw new FileNotFoundException('Cannot find source file: ' . $sourcePath);
        }
        return rename($sourcePath, $destinationPath);
    }

    /**
     * Convert file size to size with unit string.
     *
     * Example:
     * <code>
     * $unit = Files::convertUnitFileSize(146432);
     * </code>
     * Result:
     * <code>
     * 143 KB
     * </code>
     *
     * @param int $size
     * @return string
     */
    public static function convertUnitFileSize($size)
    {
        $units = array(" B", " KB", " MB", " GB");
        $calculatedSize = $size;
        $unit = Arrays::first($units);
        if ($size) {
            $calculatedSize = round($size / pow(1024, ($i = (int)floor(log($size, 1024)))), 2);
            $unit = $units[$i];
        }
        return $calculatedSize . $unit;
    }

    /**
     * Return size of the given file.
     *
     * @param string $path
     * @return int
     */
    public static function size($path)
    {
        return (int)self::exists($path) ? filesize($path) : 0;
    }

    /**
     * Check is given file is exists.
     *
     * @param string $path
     * @return bool
     */
    public static function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Return all files from the given directory that have given extension.
     *
     * @param string $dir
     * @param string $extension
     * @return array
     */
    public static function getFilesRecursivelyWithSpecifiedExtension($dir, $extension)
    {
        $directory = new RecursiveDirectoryIterator($dir);
        $iterator = new RecursiveIteratorIterator($directory);
        $filter = new RegexIterator($iterator, "/.$extension$/i", RecursiveRegexIterator::GET_MATCH);
        return array_keys(iterator_to_array($filter));
    }

    /**
     * Copy content from $inputFile to $outputFile.
     *
     * @param string $inputFile
     * @param string $outputFile
     * @param int $bufferSize
     */
    public static function copyContent($inputFile, $outputFile, $bufferSize = 1024)
    {
        $input = fopen($inputFile, 'r');
        $output = fopen($outputFile, "w");
        while ($data = fread($input, $bufferSize)) {
            fwrite($output, $data);
        }
        fclose($input);
        fclose($output);
    }
}

class FileNotFoundException extends Exception
{
}
