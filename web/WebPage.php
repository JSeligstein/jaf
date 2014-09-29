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
        $fullPath = \jaf\config\SiteConfig::inst()->staticBaseUri().$path;
        $this->stylesheets[$fullPath] = 1;
        return $this;
    }

    public function addExternalStylesheet($path) {
        $this->stylesheets[$path] = 1;
        return $this;
    }

    public function addScript($path) {
        $fullPath = \jaf\config\SiteConfig::inst()->staticBaseUri().$path;
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

        return $head;
    }

    public function headers() {
    }

    public function render() {
        return
            <x:doctype>
                <html>
                    {$this->getHead()}
                    <body>{$this->getContent()}</body>
                </html>
            </x:doctype>;
    }
}

