<?php

namespace Ouzo\Utilities;

class LoggerUtils
{
    /**
     * @param string $name
     * @param int|null $length
     * @return string
     */
    public static function shortenClassName($name, $length)
    {
        if ($length === null || $length < 0) {
            return $name;
        }

        $name = str_replace('.', '\\', $name);
        $name = trim($name, ' \\');

        // Check if any shortening is required
        $currentLength = strlen($name);
        if ($currentLength <= $length) {
            return $name;
        }

        // Split name into fragments
        $fragments = explode('\\', $name);
        // If zero length is specified, return only last fragment
        if ($length == 0) {
            return array_pop($fragments);
        }

        // If the name splits to only one fragment, then it cannot be shortened
        $count = count($fragments);
        if ($count == 1) {
            return $name;
        }

        foreach ($fragments as $key => &$fragment) {
            // Never shorten last fragment
            if ($key == $count - 1) {
                break;
            }

            // Check for empty fragments (shouldn't happen but it's possible)
            $fragLen = strlen($fragment);
            if ($fragLen <= 1) {
                continue;
            }

            // Shorten fragment to one character and check if total length satisfactory
            $fragment = substr($fragment, 0, 1);
            $currentLength = $currentLength - $fragLen + 1;

            if ($currentLength <= $length) {
                break;
            }
        }
        unset($fragment);

        return implode('\\', $fragments);
    }
}
