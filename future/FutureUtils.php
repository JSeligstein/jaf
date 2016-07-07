<?php

namespace jaf\future;

class FutureUtils {

    public static function vbegin($arr) {
        foreach ($arr as $future) {
            $future->begin();
        }
    }

    public static function vfinish($arr) {
        foreach ($arr as $future) {
            $future->finish();
        }
    }
}

