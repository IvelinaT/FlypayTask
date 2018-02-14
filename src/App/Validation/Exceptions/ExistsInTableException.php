<?php

namespace Flyt\Validation\Exceptions;

use \Respect\Validation\Exceptions\ValidationException;

class ExistsInTableException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT  => [
            self::STANDARD => 'has already been applied',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'This does not exist',
        ],
    ];
}
