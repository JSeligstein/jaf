<?php

namespace jas\exception;

class RequestParameterMissingException extends JafException {
    public $name;
    public function __construct($name) {
        parent::__construct('Parameter missing: '.$name);
        $this->name = $name;
    }
}
