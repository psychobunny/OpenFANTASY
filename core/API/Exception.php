<?php

namespace API;

/**
 * Base exception class for API exceptions
 */
class Exception extends \Exception
{
    protected $message  = 'An unknown API exception occurred';
    protected $code     = 500;
}
