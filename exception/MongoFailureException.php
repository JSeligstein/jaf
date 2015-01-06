<?php

namespace jaf\exception;

use jaf\exception\JafException;

class MongoFailureException extends JafException {
    public $result;

    public function __construct($result) {
        parent::__construct('Mongo failure.  Error: '.$result['err'].', code: '.$result['code'].' , errmsg: '.$result['errmsg']);
        $this->result = $result;
    }   
}

