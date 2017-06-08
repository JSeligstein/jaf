<?php

namespace jaf\web;

class TextView extends WebView {
    public $text = '';

    public function __construct($text) {
        $this->text = $text;
    }
        
    public function headers() {
        header('Content-type: text/plain');
    }

    public function getContent() {
        return $this->text;
    }

    public function render() {
        return $this->getContent();
    }
}
    
