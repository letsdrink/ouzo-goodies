<?php
/*
 * Copyright (c) Ouzo contributors, http://ouzoframework.org
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use finfo;
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
     * Loads a file using require or require_once if the $loadOnce flag is set to true.
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
     * Loads a file using require or require_once if the $loadOnce flag is set to true, if the file does not exist, throws FileNotFoundException.
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
     * Deletes file, throws FileNotFoundException if the file does not exist.
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
     * Deletes file if exists, otherwise return false if the file does not exist.
     * @param $path
     * @return bool
     */
    public static function deleteIfExists($path)
    {
        if (self::exists($path)) {
            return self::delete($path);
        }
        return false;
    }

    /**
     * Moves file from the source to the destination, throws FileNotFoundException if the source directory does not exist.
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
     * Converts file size in bytes to a string with unit.
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
        $units = [" B", " KB", " MB", " GB"];
        $calculatedSize = $size;
        $unit = Arrays::first($units);
        if ($size) {
            $calculatedSize = round($size / pow(1024, ($i = (int)floor(log($size, 1024)))), 2);
            $unit = $units[$i];
        }
        return $calculatedSize . $unit;
    }

    /**
     * Returns a size of the given file.
     *
     * @param string $path
     * @return int
     */
    public static function size($path)
    {
        return (int)self::exists($path) ? filesize($path) : 0;
    }

    /**
     * Checks if the given file exists.
     *
     * @param string $path
     * @return bool
     */
    public static function exists($path)
    {
        return file_exists($path);
    }

    /**
     * Returns all files from the given directory that have the given extension.
     *
     * @param string $dir
     * @param string $extension
     * @return array
     */
    public static function getFilesRecursivelyWithSpecifiedExtension($dir, $extension)
    {
        $directory = new RecursiveDirectoryIterator($dir);
        $iterator = new RecursiveIteratorIterator($directory);
        $filter = new RegexIterator($iterator, "/\.$extension$/i", RecursiveRegexIterator::GET_MATCH);
        return array_keys(iterator_to_array($filter));
    }

    /**
     * Copies content from $inputFile to $outputFile.
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

    /**
     * Returns mime type for the given file path.
     *
     * @param string $path
     * @return string
     */
    public static function mimeType($path)
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        return $fileInfo->file($path);
    }

    /**
     * Returns class name if file contains class or false if not, throws FileNotFoundException when file does not exist
     *
     * @param string $filePath - path to file
     * @return bool|string - false if file doesn't contain class or class name if file contains class
     * @throws FileNotFoundException - error thrown when file does not exist
     */
    public static function checkWhetherFileContainsClass($filePath)
    {
        if (!self::exists($filePath)) {
            throw new FileNotFoundException('Cannot find source file: ' . $filePath);
        }
        $fp = fopen($filePath, 'r');
        $class = false;
        $buffer = '';
        $i = 0;
        while (!$class && !feof($fp)) {

            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) continue;

            for (; $i < count($tokens); $i++) {
                if ($tokens[$i][0] === T_CLASS) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                        }
                    }
                }
            }
        }
        return $class;
    }
}
