<?php

namespace jaf\web;

class Uri {
    public static function redirect($uri) {
        // todo: is exit the proper thing here?
        header('Location: '.$uri);
        exit;
    }
}
