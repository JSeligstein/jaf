<?php

namespace jaf\mysql;

use jaf\mysql\MySQLConnection;

class MySQLQuery {
    private $escapedQuery;

    public static function build(MySQLConnection $conn, $pattern /*, ... */) {
        $args = func_get_args();
        return new MySQLQuery(call_user_func_array('qsprintf', $args));
    }   

    public static function vbuild(MySQLConnection $conn, $pattern, $params) {
        array_unshift($params, $pattern);
        array_unshift($params, $conn);
        return new MySQLQuery(call_user_func_array('qsprintf', $params));
    }   

    private function __construct($escapedQuery) {
        $this->escapedQuery = $escapedQuery;
    }   

    public function getEscapedQuery() {
        return $this->escapedQuery;
    }   
}
