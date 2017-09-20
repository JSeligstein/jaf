<?php

namespace jaf\mysql;

use jaf\mysql\MySQLConfiguration;
use jaf\mysql\MySQLQuery;

class MySQLConnection implements \PhutilQsprintfInterface {

    private $conn;
    private $conf;

    public function __construct(MySQLConfiguration $conf) {
        $this->conf = $conf;
    }   

    public function configuration() {
        return $this->conf;
    }   

    public function connect() {
        $conn = mysql_connect(
            $this->conf->host,
            $this->conf->username,
            $this->conf->password);

        // TODO: log error

        if (!$conn || !mysql_select_db($this->conf->database)) {
            throw new \jaf\exception\MySQLConnectFailedException(
                $this->conf,
                mysql_errno($conn),
                mysql_error($conn));
        }   
            
        $this->conn = &$conn;
    }   

    public function disconnect() {
        if ($this->conn) {
            mysql_close($this->conn);
            $this->conn = null;
        }   
    }   

    public function requireConnection() {
        if (!$this->conn) {
            $this->connect();
        }   
        return $this->conn;
    }   

    public function buildQuery($pattern /*, ... */) {
        $params = func_get_args();
        $pattern = array_shift($params);
        return MySQLQuery::vbuild($this, $pattern, $params);
    }

    public function vbuildQuery($pattern, $params) {
        return MySQLQuery::vbuild($this, $pattern, $params);
    }

    public function runQuery(MySQLQuery $query) {
        $conn = $this->requireConnection();
        $result = mysql_query($query->getEscapedQuery(), $conn);
        if ($result === false) {
            throw new \jaf\exception\MySQLQueryFailedException(
                $query,
                mysql_errno($conn),
                mysql_error($conn));
        }
        return $result;
    }

    public function lastInsertId() {
        return mysql_insert_id($this->requireConnection());
    }

    public function affectedRows($result) {
        return mysql_affected_rows($result);
    }

    public function numRows($result) {
        return mysql_num_rows($result);
    }

    public function fetchRow($result) {
        return mysql_fetch_assoc($result);
    }

    public function fetchAll($result, $key=null) {
        $rows = array();
        while ($row = mysql_fetch_assoc($result)) {
            if ($key && array_key_exists($key, $row)) {
                $rows[$row[$key]] = $row;
            } else {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * PhutilQsprintfInterface
     */

    public function escapeUTF8String($string) {
        return $this->escapeBinaryString($string);
    }

    public function escapeBinaryString($string) {
        return mysql_real_escape_string($string, $this->requireConnection());
    }

    public function escapeColumnName($name) {
        return '`'.str_replace('`', '``', $name).'`';
    }

    public function escapeMultilineComment($comment) {
        // These can either terminate a comment, confuse the hell out of the parser, 
        // make MySQL execute the comment as a query, or, in the case of semicolon,
        // are quasi-dangerous because the semicolon could turn a broken query into
        // a working query plus an ignored query.

        static $map = array(
            '--'  => '(DOUBLEDASH)',
            '*/'  => '(STARSLASH)',
            '//'  => '(SLASHSLASH)',
            '#'   => '(HASH)',
            '!'   => '(BANG)',
            ';'   => '(SEMICOLON)',
        );

        $comment = str_replace(
            array_keys($map),
            array_values($map),
            $comment);

        // For good measure, kill anything else that isn't a nice printable
        // character.
        $comment = preg_replace('/[^\x20-\x7F]+/', ' ', $comment);

        return '/* '.$comment.' */';
    }

    public function escapeStringForLikeClause($value) {
        $value = addcslashes($value, '\%_');
        $value = $this->escapeUTF8String($value);
        return $value;
    }
}

