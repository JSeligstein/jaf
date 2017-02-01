<?php

namespace jaf\tools;

class Generator {

    public static function randSecure($min, $max) {
    	$range = $max - $min;
    	if ($range < 1) {
			return $min;
		}

    	$log = ceil(log($range, 2));
    	$bytes = (int) ($log / 8) + 1; // length in bytes
    	$bits = (int) $log + 1; // length in bits
    	$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    	do {
        	$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        	$rnd = $rnd & $filter; // discard irrelevant bits
    	} while ($rnd > $range);
    	return $min + $rnd;
	}


    public static function token($length) {
        $chars = 'abcdefghijklmnopqrstuvwxyz'
			   . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
			   . '0123456789';
        $charLen = strlen($chars);
        $result = '';
        while (strlen($result) < $length) {
            $result .= $chars[self::randSecure(0, $charLen-1)];
        }
        return $result;
    }

	// storing in case someone else uses it
	public function salt($length) {
		return Generator::token($length);
	}
}
            
