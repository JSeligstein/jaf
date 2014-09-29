<?php

namespace jaf\web;

use jaf\web\WebRequest;
use jaf\exception\SiteException;

abstract class WebSite {
    protected $config;
    protected $router;
    protected $request;
    protected $controller;
    protected $view;

    private $processed = false;

    abstract public function getConfig();
    abstract public function getRouter();

    public function __construct() {
        $this->config = $this->getConfig();
        $this->router = $this->getRouter();
        $this->request = WebRequest::newDefault();
        $this->controller = $this->router->getController($this->request);
        $this->processed = false;
    }

    public function process() {
        if ($this->processed) {
            throw new SiteException('Process was called twice.');
        }

        $this->controller->process();
        $this->processed = true;
    }

    public function render() {
        if (!$this->processed) {
            throw new SiteException('Render was called without process.');
        }

        $this->view = $this->controller->getView();
        $this->view->setSite($this);
        $this->view->setController($this->controller);
        $this->view->headers();
        return $this->view->render();
    }
}

