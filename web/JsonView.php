<?php

namespace jaf\web;

class JsonView extends WebView {
    public $json = '';

    public function __construct($json) {
        $this->json = $json;
    }

    public function headers() {
        header('Content-type: text/json');
    }

    public function getContent() {
        return $this->json;
    }

    public function render() {
        return json_encode($this->getContent());
    }
}
    
