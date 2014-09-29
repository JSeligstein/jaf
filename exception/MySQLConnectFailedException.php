<?php

namespace jaf\exception;

use jaf\exception\JafException;
use jaf\mysql\MySQLConfiguration;

class MySQLConnectFailedException extends JafException {
    public $conf;
    public $errno;
    public $errmsg;

    public function __construct(MySQLConfiguration $conf, $errno, $errmsg) {
        parent::__construct('Connect failed to: '.$conf->username.'@'.$conf->host."\n"
                            .'Code: '.$errno.', Message: '.$errmsg);
        $this->conf = $conf;
        $this->errno = $errno;
        $this->errmsg = $errmsg;
    }   
}
