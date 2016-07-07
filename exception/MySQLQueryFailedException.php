<?php

namespace jaf\exception;

use jaf\exception\JafException;

class MySQLQueryFailedException extends JafException {
    public $query;
    public $errno;
    public $errmsg;

    public function __construct($query, $errno, $errmsg) {
        parent::__construct('Query failed: '.$query->getEscapedQuery()."\n"
                            .'Code: '.$errno.', Message: '.$errmsg);
        $this->query = $query;
        $this->errno = $errno;
        $this->errmsg = $errmsg;
    }   
}

