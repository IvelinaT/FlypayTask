<?php
namespace Flyt\Validation\Exceptions;

use \Respect\Validation\Exceptions\ValidationException;

class ReferenceAvailableException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT  => [
            self::STANDARD => 'Reference already exists.',
        ],
        self::MODE_NEGATIVE => [
            self::STANDARD => 'Reference does not exist',
        ],
    ];
}