<?php

namespace jaf\web;

abstract class WebPage extends WebView {

    private $stylesheets;
    private $scripts;

    abstract public function getTitle();

    public function __construct() {
        $this->stylesheets = array();
        $this->scripts = array();
    }

    public function addStylesheet($path) {
        $fullPath = $this->getSite()->getConfig()->staticBaseUri().$path;
        $this->stylesheets[$fullPath] = 1;
        return $this;
    }

    public function addExternalStylesheet($path) {
        $this->stylesheets[$path] = 1;
        return $this;
    }

    public function addScript($path) {
        $fullPath = $this->getSite()->getConfig()->staticBaseUri().$path;
        $this->scripts[$fullPath] = 1;
        return $this;
    }

    public function addExternalScript($path) {
        $this->scripts[$path] = 1;
        return $this;
    }

    private function getHead() {
        $head =
            <head>
                <title>{$this->getTitle()}</title>
            </head>;

        foreach ($this->stylesheets as $sheet => $_) {
            $head->appendChild(
                <link rel="stylesheet" href={$sheet} type="text/css" />
            );
        }

        foreach ($this->scripts as $script => $_) {
            $head->appendChild(
                <script type="text/javascript" src={$script} />
            );
        }

        return $head;
    }

    public function headers() {
    }

    public function render() {
        $content = $this->getContent();

        return
            <x:doctype>
                <html>
                    {$this->getHead()}
                    <body>{$content}</body>
                </html>
            </x:doctype>;
    }
}

