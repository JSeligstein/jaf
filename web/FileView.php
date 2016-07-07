<?php

namespace jaf\web;

abstract class FileView extends WebView {
    
    abstract public function getMimeType();
    abstract public function getFilePath();

    public function headers() {
        header('Content-Type: '.$this->getMimeType());
        header('Content-Length: '.filesize($this->getFilePath()));
    }

    public function getContent() {
        return file_get_contents($this->getFilePath());
    }

    public function render() {
        return $this->getContent();
    }
}
    
