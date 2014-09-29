<?php

namespace jaf\exception;

use jaf\exception\JafException;
use jaf\log\Logger;

class SiteException extends JafException {

    public function __construct($message) {
        parent::__construct($message);
        Logger::error($message);
    }
}

