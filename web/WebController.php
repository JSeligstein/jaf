<?php

namespace jaf\web;

use jaf\exception\FourOhFourException;

abstract class WebController {

    public $request;

    public function __construct(\jaf\web\WebRequest $request) {
        $this->request = $request;
    }

    public function go404() {
        throw new FourOhFourException();
    }

    abstract public function process();
    abstract public function getView();
}

