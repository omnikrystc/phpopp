<?php
/*
 * Design Pattern: Registry
 * -- see Registry.php for details
 * 
 */
namespace edp\registry; 

require_once('Registry.php');

class SessionRegistry extends Registry {
    private static $instance;
    
    private function __construct() {
        session_start();
    }
    
    static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    protected function get($key) {
        if (isset($_SESSION[__CLASS__][$key])) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }
    
    protected function set($key, $value) {
        $_SESSION[__CLASS__][$key] = $value;
    }
    
    static function setComplex(Complex $complex) {
        self::$instance()->set('complex', $complex);
    }
    
    static function getComplex() {
        return self::$instance()->get('complex');
    }
}
