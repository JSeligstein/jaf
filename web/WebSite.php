<?php

namespace jaf\web;

use jaf\web\WebRequest;
use jaf\exception\FourOhFourException;
use jaf\exception\SiteException;

abstract class WebSite {
    protected $config;
    protected $router;
    protected $request;
    protected $controller;
    protected $view;

    private $processed = false;
    private static $_inst = null;

    abstract public function getConfig();
    abstract public function getRouter();

    public static function instance() {
        if (self::$_inst == null) {
            throw new SiteException('Website::instance was called before any instantiation');
        }
        return self::$_inst;
    }

    public function __construct() {
        if (self::$_inst != null) {
            throw new SiteException('Website class is a singleton but was instantiated twice!');
        }

        self::$_inst = $this;

        $this->config = $this->getConfig();
        $this->router = $this->getRouter();
        $this->request = WebRequest::newDefault();
        $this->controller = $this->router->getController($this->request);
        $this->processed = false;
    }

    public function getController() {
        return $this->controller;
    }

    public function getView() {
        if (empty($this->view)) {
            throw new SiteException('GetView was called before render');
        }
        return $this->view;
    }

    public function process() {
        if ($this->processed) {
            throw new SiteException('Process was called twice.');
        }

        try {
            $this->controller->process();
        } catch (FourOhFourException $fofe) {
            $this->controller = $this->router->get404Controller($this->request);
            $this->controller->process();
        } catch (\Exception $e) {
            $this->controller = $this->router->getExceptionController($this->request);
            $this->controller->exception = $e;
            $this->controller->process();
        }
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

