<?php

namespace jaf\web;

abstract class TextView extends WebView {
    public function headers() {
        header('Content-type: text/plain');
    }

    public function render() {
        return $this->getContent();
    }
}
    
