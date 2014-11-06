<?php

namespace jaf\tools;

use jaf\exception\ValidationException;

class Validator {

    public static function integer($name, $value) {
        if (!is_int($value)) {
            throw new ValidationException($name.' was expected to be integer.');
        }
    }
   
    public static function number($name, $value) {
        if (!is_int($value) && !is_double($value) && !is_float($value)) {
            throw new ValidationException($name.' was expected to be number.');
        }
    }
    
    
    public static function nonzero($name, $value) {
        self::number($name, $value);
        if ($value == 0) {
            throw new ValidationException($name.' was expected to be nonzero.');
        }
    }

    public static function zero($name, $value) {
        self::number($name, $value);
        if ($value != 0) {
            throw new ValidationException($name.' was expected to be zero.');
        }
    }

    public static function positive($name, $value) {
        self::number($name, $value);
        if ($value <= 0) {
            throw new ValidationException($name.' was expected to be positive.');
        }
    }

    public static function negative($name, $value) {
        self::number($name, $value);
        if ($value >= 0) {
            throw new ValidationException($name.' was expected to be negative.');
        }
    }

    public static function nonempty($name, $value) {
        if (empty($value)) {
            throw new ValidationException($name.' was expected to be nonempty.');
        }
    }

    public static function empty($name, $value) {
        if (!empty($value)) {
            throw new ValidationException($name.' was expected to be empty.');
        }
    }

}

