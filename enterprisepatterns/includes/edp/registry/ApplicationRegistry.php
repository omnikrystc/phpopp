<?php
/*
 * Design Pattern: Registry
 * -- see Registry.php for details
 * 
 */
namespace edp\registry; 

require_once('Registry.php');
require_once('includes/edp/controller/AppController.php');
require_once('includes/edp/controller/ControllerMap.php');

class ApplicationRegistry extends Registry {
    private static $instance;
    private $freezedir = 'data';
    private $values = array();
    private $mtimes = array();
    
    private function __construct() {}
    
    static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    protected function get($key) {
        $path = $this->freezedir.DIRECTORY_SEPARATOR.$key;
        if (file_exists($path)) {
            clearstatcache();
            $mtime = filemtime($path);
            if (!isset($this->mtimes[$key])) {
                $this->mtimes[$key] = 0;
            }
            if ($mtime > $this->mtimes[$key]) {
                $data = file_get_contents($path);
                $this->mtimes[$key] = $mtime;
                return ($this->values[$key] = unserialize($data));
            }
            
           if (isset($this->values[$key])) {
               return $this->values[$key];
           }
           return null;
        }
        if (isset($_SESSION[__CLASS__][$key])) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }
    
    protected function set($key, $value) {
        $this->values[$key] = $value;
        $path = $this->freezedir.DIRECTORY_SEPARATOR.$key;
        file_put_contents($path, serialize($value));
        $this->mtimes[$key] = time();
    }
    
    static function setDSN($dsn) {
        self::instance()->set('dsn', $dsn);
    }
    
    static function getDSN() {
        return self::instance()->get('dsn');
    }

    static function setControllerMap(\edp\controller\ControllerMap $map) {
        self::instance()->set('cmap', $map);
    }

    static function getControllerMap() {
        return self::instance()->get('cmap');
    }

    static function appController() {
        $instance = self::instance();
        if (!isset($instance->appController)) {
            $cmap = $instance->getControllerMap();
            $instance->appController = new \edp\controller\AppController($cmap);
        }
        return $instance->appController;
    }
}
