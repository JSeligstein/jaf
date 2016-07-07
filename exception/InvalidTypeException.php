<?php

namespace jaf\exception;

class InvalidTypeException extends JafException {
    public $type;
    public $value;
    public function __construct($type, $value) {
        parent::__construct('Invalid type. Expected: '.$type.', got: '.$value);
        $this->type = $type;
        $this->value = $value;
    }
}
