<?php

namespace jaf\exception;

use jaf\exception\JafException;

class MongoUpdateVersionMismatchException extends JafException {
    public $result;

    public function __construct($result) {
        parent::__construct('Mongo tried to update a record, but there was a version mismatch.');
        $this->result = $result;
    }   
}

