<?php
/*
 * wraps the request object so that we can use this for
 * more than just web serving. Also, add an additional
 * services that apply to the request.
 * 
 */
namespace edp\controller;

class Request {
    private $properties;
    private $feedback = array();
    
    function __construct() {
        $this->init();
    }
    
    function init() {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->properties = $_REQUEST;
            return;
        }
        
        foreach ($_SERVER['argv'] as $arg) {
            if (strpos($arg, '=')) {
                list($key, $value) = explode('=', $arg);
                $this->setProperty($key, $value);
            }
        }
    }
    
    function getProperty($key) {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
        return null;
    }
    
    function setProperty($key, $value) {
        $this->properties[$key] = $value;
    }
    
    function addFeedback($message) {
        array_push($this->feedback, $message);
    }
    
    function getFeedback() {
        return $this->feedback;
    }
    
    function getFeedbackString($seperator = PHP_EOL) {
        return implode($seperator, $this->feedback);
    }
}
