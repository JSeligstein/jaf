<?php

namespace jaf\web;

class WebRequest {

    public $get;
    public $post;
    public $path;

    public static function newDefault() {
        $r = new WebRequest();
        $r->get = new \jaf\web\RequestData($_GET);
        $r->post = new \jaf\web\RequestData($_POST);

        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false
                  ? 'http'
                  : 'https';
        $host     = $_SERVER['HTTP_HOST'];   // Get  www.domain.com
        $path     = $_GET['path'];
        $script   = $_SERVER['SCRIPT_NAME']; // Get folder/file.php
        $params   = $_SERVER['QUERY_STRING'];// Get Parameters occupation=odesk&name=ashik

        $uri = new Uri($protocol.'://'.$host.$script.'?'.$params);
        $uri->setPath($uri->getParam('path'));
        $uri->removeParam('path');
        $r->path = $uri;

        return $r;
    }
}

    
