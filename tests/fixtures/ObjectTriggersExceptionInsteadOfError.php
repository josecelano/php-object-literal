<?php

namespace Tests\ObjectLiteral\fixtures;

use ObjectLiteral\Object;

final class ObjectTriggersExceptionInsteadOfError extends Object
{
    public $nonCallableProperty = null;

    protected function triggerError($errorMsg, $errorType = E_USER_NOTICE)
    {
        throw new \Exception($errorMsg, $errorType);
    }
}