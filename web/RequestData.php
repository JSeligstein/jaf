<?php

namespace jaf\web;

class RequestData {
    public $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function getInt($name, $default=0) {
        if (isset($this->data[$name])) {
            if (ctype_digit((string)$this->data[$name])) {
                return (int)$this->data[$name];
            } else {
                throw new \jaf\exception\RequestParameterInvalidException('int', $name, $this->data[$name]);
            }
        }
        return $default;
    }

    public function requireInt($name) {
        $this->requireExists($name);
        return $this->getInt($name);
    }

    public function getFloat($name, $default=0) {
        if (isset($this->data[$name])) {
            if (is_numeric((string)$this->data[$name])) {
                return (float)$this->data[$name];
            } else {
                throw new \jaf\exception\RequestParameterInvalidException('float', $name, $this->data[$name]);
            }
        }
        return $default;
    }

    public function requireFloat($name) {
        $this->requireExists($name);
        return $this->getFloat($name);
    }

    public function getString($name, $default='') {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return $default;
    }

    public function requireString($name) {
        $this->requireExists($name);
        return $this->getString($name);
    }

    public function getBool($name, $default=false) {
        if (isset($this->data[$name])) {
            if ($this->data[$name] === 'true') {
                return true;
            } elseif ($this->data[$name] === 'false') {
                return false;
            } else {
                return (bool)$this->data[$name];
            }
        }
        return $default;
    }

    public function requireBool($name) {
        $this->requireExists($name);
        return $this->getBool($name);
    }

    public function getObject($name, $default='') {
        if (isset($this->data[$name])) {
            return (array)$this->data[$name];
        }
        return $default;
    }

    public function requireObject($name) {
        $this->requireExists($name);
        return $this->getObject($name);
    }

    public function getExists($name) {
        return isset($this->data[$name]);
    }

    public function requireExists($name) {
        if (isset($this->data[$name])) {
            return true;
        }
        throw new \jaf\exception\RequestParameterMissingException($name);
    }

}
