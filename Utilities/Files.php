<?php
/*
 * Copyright (c) Ouzo contributors, https://github.com/letsdrink/ouzo
 * This file is made available under the MIT License (view the LICENSE file for more information).
 */

namespace Ouzo\Utilities;

use finfo;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class Files
{
    /** Loads a file using require or require_once if the $loadOnce flag is set to true. */
    public static function loadIfExists(string $path, bool $loadOnce = true): bool
    {
        if (self::exists($path)) {
            self::require($path, $loadOnce);
            return true;
        }
        return false;
    }

    /**
     * Loads a file using require or require_once if the $loadOnce flag is set to true.
     * If the file does not exist it throws FileNotFoundException.
     */
    public static function load(string $path, bool $loadOnce = true): void
    {
        if (!self::loadIfExists($path, $loadOnce)) {
            throw new FileNotFoundException("Cannot load file: {$path}");
        }
    }

    private static function require(string $path, bool $loadOnce): void
    {
        if ($loadOnce) {
            /** @noinspection PhpIncludeInspection */
            require_once($path);
        } else {
            /** @noinspection PhpIncludeInspection */
            require($path);
        }
    }

    /** Deletes file, throws FileNotFoundException if the file does not exist. */
    public static function delete(string $path): bool
    {
        if (!self::exists($path)) {
            throw new FileNotFoundException('Cannot find file: ' . $path);
        }
        return unlink($path);
    }

    /** Deletes file if exists, otherwise return false if the file does not exist. */
    public static function deleteIfExists(string $path): bool
    {
        if (self::exists($path)) {
            return self::delete($path);
        }
        return false;
    }

    /**
     * Moves file from the source to the destination.
     * Throws FileNotFoundException if the source directory does not exist.
     */
    public static function move(string $sourcePath, string $destinationPath): bool
    {
        if (!self::exists($sourcePath)) {
            throw new FileNotFoundException("Cannot find source file: {$sourcePath}");
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
     */
    public static function convertUnitFileSize(string $size): string
    {
        $units = [" B", " KB", " MB", " GB"];
        $calculatedSize = $size;
        $unit = Arrays::first($units);
        if ($size) {
            $calculatedSize = round($size / pow(1024, ($i = (int)floor(log($size, 1024)))), 2);
            $unit = $units[$i];
        }
        return "{$calculatedSize}{$unit}";
    }

    /** Returns a size of the given file. */
    public static function size(string $path): int
    {
        return (int)self::exists($path) ? filesize($path) : 0;
    }

    /** Checks if the given file exists. */
    public static function exists(string $path): bool
    {
        return file_exists($path);
    }

    /** Returns all files from the given directory that have the given extension. */
    public static function getFilesRecursivelyWithSpecifiedExtension(string $dir, string $extension): array
    {
        $directory = new RecursiveDirectoryIterator($dir);
        $iterator = new RecursiveIteratorIterator($directory);
        $filter = new RegexIterator($iterator, "/\.$extension$/i", RecursiveRegexIterator::GET_MATCH);
        return array_keys(iterator_to_array($filter));
    }

    /** Copies content from $inputFile to $outputFile. */
    public static function copyContent(string $inputFile, string $outputFile, int $bufferSize = 1024): void
    {
        $input = fopen($inputFile, 'r');
        $output = fopen($outputFile, "w");
        while ($data = fread($input, $bufferSize)) {
            fwrite($output, $data);
        }
        fclose($input);
        fclose($output);
    }

    /** Returns mime type for the given file path. */
    public static function mimeType(string $path): string
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        return $fileInfo->file($path);
    }

    /**
     * Returns class name if file contains class or false if not.
     * Throws FileNotFoundException when file does not exist
     */
    public static function checkWhetherFileContainsClass(string $filePath): bool|string
    {
        if (!self::exists($filePath)) {
            throw new FileNotFoundException("Cannot find source file: {$filePath}");
        }

        $fp = fopen($filePath, 'r');
        $class = false;
        $buffer = '';
        $i = 0;
        while (!$class && !feof($fp)) {

            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (!str_contains($buffer, '{')) {
                continue;
            }

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
