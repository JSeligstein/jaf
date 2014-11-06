<?php

namespace jaf\tools;

class Generator {

    public function salt($length) {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789-_';
        $charLen = strlen($chars);
        $result = '';
        while ($length > 0) {
            $result .= $chars[rand(0, $charLen-1)];
        }
        return $result;
    }
}
            
