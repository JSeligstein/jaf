<?php

namespace jaf\web;

abstract class WebController {

    public $request;

    public function __construct(\jaf\web\WebRequest $request) {
        $this->request = $request;
    }

    abstract public function process();
    abstract public function getView();
}

