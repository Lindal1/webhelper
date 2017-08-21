<?php

namespace lindal\webhelper\errors;

use Throwable;

class NotFoundException extends \Exception
{

    public function __construct($message = "Page not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}