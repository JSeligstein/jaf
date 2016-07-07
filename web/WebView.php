<?php

namespace jaf\web;

abstract class WebView {

    public $controller;
    public $site;

    public function setController(WebController $controller) {
        $this->controller = $controller;
        return $this;
    }

    public function getController() {
        return $this->controller;
    }

    public function setSite(WebSite $site) {
        $this->site = $site;
        return $this;
    }

    public function getSite() {
        return $this->site;
    }

    abstract protected function getContent();
    abstract public function headers();
    abstract public function render();
}
