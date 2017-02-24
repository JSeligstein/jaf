<?php

namespace jaf\web;

abstract class WebPage extends WebView {

    private $stylesheets;
    private $scripts;
    private $footerScripts;

    abstract public function getTitle();

    public function __construct() {
        $this->stylesheets = array();
        $this->scripts = array();
        $this->footerScripts = array();
    }

    public function getStaticPath($path) {  
        return $this->getSite()->getConfig()->staticBaseUri().$path;
    }

    public function addStylesheet($path) {
        $fullPath = $this->getStaticPath($path);
        $this->stylesheets[$fullPath] = 1;
        return $this;
    }

    public function addExternalStylesheet($path) {
        $this->stylesheets[$path] = 1;
        return $this;
    }

    public function addScript($path) {
        $fullPath = $this->getStaticPath($path);
        $this->scripts[$fullPath] = 1;
        return $this;
    }

    public function addExternalScript($path) {
        $this->scripts[$path] = 1;
        return $this;
    }

    public function addFooterScript($path) {
        $fullPath = $this->getStaticPath($path);
        $this->footerScripts[$fullPath] = 1;
        return $this;
    }

    public function addExternalFooterScript($path) {
        $this->footerScripts[$path] = 1;
        return $this;
    }

    private function getHead() {
        $head =
            <head>
                <title>{$this->getTitle()}</title>
                {$this->headers()}
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

    private function getFooterScripts() {
        $scripts = <x:frag />;
        foreach ($this->footerScripts as $script => $_) {
            $scripts->appendChild(
                <script type="text/javascript" src={$script} />
            );
        }
        return $scripts;
    }

    public function render() {
        // force render first
        $content = $this->getContent();
        $content->__toString();
        $head = $this->getHead();

        return
            <x:doctype>
                <html>
                    {$head}
                    <body>
                        {$content}
                        {$this->getFooterScripts()}
                    </body>
                </html>
            </x:doctype>;
    }
}

