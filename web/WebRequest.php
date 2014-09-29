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
        $r->path = $_SERVER['HTTP_HOST'];
        return $r;
    }
}

    
