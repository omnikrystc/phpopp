<?php
/*
 * Design Pattern: Registry
 * -- see Registry.php for details
 * 
 */
namespace edp\registry; 

require_once('Registry.php');
require_once('includes/edp/controller/Request.php');
require_once('includes/edp/controller/AppController.php');
require_once('includes/edp/controller/ControllerMap.php');

class RequestRegistry extends Registry {
    private $values = array();
    private static $instance;
    
    private function __construct() {}
    
    static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    protected function get($key) {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }
    
    protected function set($key, $value) {
        $this->values[$key] = $value;
    }
    
    static function getRequest() {
        $instance = self::instance();
        if (is_null($instance->get('request'))) {
            $instance->set('request', new \edp\controller\Request());
        }
        return $instance->get('request');
    }
    
    static function setRequest(\edp\controller\Request $request) {
        $this::instance()->set('request', $request);
    }
}
