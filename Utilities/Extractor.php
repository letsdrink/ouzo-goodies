<?php
namespace Ouzo\Utilities;

/**
 * Sample usage:
 *
 * <code>
 *  $cities = Arrays::map($users, Functions::extract()->getAddress('home')->city);
 * </code>
 */
class Extractor
{
    private $_operations = array();

    public function __get($field)
    {
        $this->_operations[] = function ($input) use ($field) {
            return Objects::getValue($input, $field);
        };
        return $this;
    }

    public function __call($name, $arguments)
    {
        $this->_operations[] = function ($input) use ($name, $arguments) {
            return call_user_func_array(array($input, $name), $arguments);
        };
        return $this;
    }

    public function __invoke($input)
    {
        foreach ($this->_operations as $operation) {
            $input = $operation($input);
            if ($input === null) {
                return null;
            }
        }
        return $input;
    }
}
