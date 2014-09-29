<?php

namespace jaf\exception;

class RequestParameterInvalidException extends JafException {
    public $paramType;
    public $paramName;
    public $paramValue;
    public function __construct($paramType, $paramName, $paramValue) {
        parent::__construct('Parameter invalid: '.$paramName
                            .', Expected '.$paramType.', value: '.$paramValue);
        $this->paramType = $paramType;
        $this->paramName = $paramName;
        $this->paramValue = $paramValue;
    }
}
