<?php

namespace App\Platforms\Exceptions;

class EmailAlreadyExistsException extends \Exception
{
    protected $message = 'Email already exists';
}