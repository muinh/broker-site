<?php

namespace App\Platforms\Exceptions;

class UserNotFoundException extends \Exception
{
    protected $message = 'User not found';
    protected $code = 404;
}