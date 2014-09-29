<?php

namespace jaf\web;

abstract class WebView {

    public $controller;

    public function setController($controller) {
        $this->controller = $controller;
        return $this;
    }

    public function getController() {
        return $this->controller;
    }

    abstract protected function getContent();
    abstract public function headers();
    abstract public function render();
}
