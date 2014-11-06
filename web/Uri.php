<?php

namespace jaf\web;

class Uri {
    public static function redirect($uri) {
        // todo: is exit the proper thing here?
        header('Location: '.$uri);
        exit;
    }

    private $uriStr = '';
    private $path = '';
    private $protocol = '';
    private $domain = '';
    private $subdomain = '';
    private $fullDomain = '';
    private $queryParams = array();

    public function __construct($uriStr) {
        $this->uriStr = $uriStr;
        $this->parse();
    }

    private function parse() {

        $uri = $this->uriStr;
        
        // check for a protocol
        $protocolLoc = strpos($uri, '://');
        if ($protocolLoc !== false) {
            if ($protocolLoc > 0) {
                $this->protocol = substr($uri, 0, $protocolLoc);
            }
            $uri = substr($uri, $protocolLoc+3);
        }

        // find domain
        $firstSlashLoc = strpos($uri, '/');
        if ($firstSlashLoc === false) {
            $this->fullDomain = $uri;
            $uri = '';
        } else {
            $this->fullDomain = substr($uri, 0, $firstSlashLoc);
            $uri = substr($uri, $firstSlashLoc+1);
        }
        $this->parseFullDomain();

        // is there a query string?
        $qLoc = strpos($uri, '?');
        if ($qLoc !== false) {
            $queryStr = substr($uri, $qLoc+1);
            $uri = substr($uri, 0, $qLoc);
            $this->parseQueryStr($queryStr);
        }

        // whatever left over is the path
        $this->path = $uri;
    }

    protected function parseFullDomain() {
        $domainPieces = explode('.', $this->fullDomain);
        $pieceCount = count($domainPieces);
        if ($pieceCount <= 2) {
            $this->domain = $this->fullDomain;
        } else {
            $this->subdomain = implode('.', array_slice($domainPieces, 0, $pieceCount-2));
            $this->domain = $domainPieces[$pieceCount-2].'.'.$domainPieces[$pieceCount-1];
        }
    }

    protected function parseQueryStr($str) {
        $this->queryParams = array();
        $params = explode('&', $str);
        foreach ($params as $param) {
            $paramPieces = explode('=', $param, 2);
            if (count($paramPieces) == 1) {
                $this->queryParams[$param] = null;
            } else {
                $this->queryParams[$paramPieces[0]] = $paramPieces[1];
            }
        }
    }

    
    public function __toString() {
        $str = '';

        if ($this->protocol) {
            $str .= $this->protocol.'://';
        }

        $str .= $this->fullDomain.'/'.$this->path;
        if ($this->queryParams) {
            $str .= '?'.$this->getQueryStr();
        }
        return $str;
    }

    /**********
    * GETTERS *
    **********/

    public function getProtocol() {
        return $this->protocol;
    }

    public function getPath() {
        return $this->path;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function getSubdomain() {
        return $this->subdomain;
    }

    public function getFullDomain() {
        return $this->fullDomain;
    }

    public function getQueryStr() {
        $paramStrs = array();
        foreach ($this->queryParams as $k => $v) {
            if ($v === null) {
                $paramStrs[] = $k;
            } else {
                $paramStrs[] = $k.'='.$v;
            }
         }
         return implode('&', $paramStrs);
    }

    /**********
    * SETTERS *
    **********/

    public function setProtocol($protocol) {
        $this->protocol = $protocol;
        return $this;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setDomain($domain) {
        $this->domain = $domain;
        if ($this->subdomain) {
            $this->fullDomain = $this->subdomain.'.'.$this->domain;
        }
        return $this;
    }

    public function setSubdomain($subdomain) {
        $this->subdomain = $subdomain;
        $this->fullDomain = $this->subdomain.'.'.$this->domain;
        return $this;
    }

    public function setFullDomain($fullDomain) {
        $this->fullDomain = $fullDomain;
        $this->parseFullDomain();
        return $this;
    }

    public function setQueryStr($str) {
        $this->parseQueryStr($str);
        return $this;
    }

    public function setParam($key, $value=null) {
        $this->queryParams[$key] = $value;
        return $this;
    }

    public function clearParams() {
        $this->queryParams = array();
        return $this;
    }

    public function removeParam($key) {
        unset($this->queryParams[$key]);
        return $this;
    }

}
