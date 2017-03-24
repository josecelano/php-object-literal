<?php

namespace ObjectLiteral;

/**
 * Object.
 *
 * @author Jose Celano
 */
class Object extends \stdClass
{
    public function __construct($value = null)
    {
        if (is_null($value) || $value == '') {
            return;
        }

        if (is_array($value)) {
            $object = (object)$value;
            $this->importPropertiesFrom($object);
            return;
        }

        if (is_string($value)) {
            $object = json_decode($value);
            if (!is_null($object)) {
                $this->importPropertiesFrom($object);
                return;
            }
        }

        throw new \InvalidArgumentException('Object can not be build from value ' . var_export($value, true));
    }

    public function __call($name, $args)
    {
        if (!is_callable($this->$name)) {
            $this->triggerError("Not callable property: $name", E_ERROR);
        }

        array_unshift($args, $this);
        return call_user_func_array($this->$name, $args);
    }

    protected function triggerError($errorMsg, $errorType = E_USER_NOTICE)
    {
        $this->triggerError($errorMsg, $errorType);
    }

    private function importPropertiesFrom($object)
    {
        foreach (get_object_vars($object) as $key => $value) {
            if (is_scalar($value) || is_callable($value)) {
                $this->$key = $value;
                continue;
            }
            $this->$key = new Object($value);
        }
    }
}
