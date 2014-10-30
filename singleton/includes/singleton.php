<?php
/*
 * Design Pattern: Singleton
 * 
 * Problem: Need a centralized application-level
 * object that can have only 1 instance. For things
 * like global settings, database access, etc.
 *
 * Implementation:  Make the constructor private and
 * create a getInstance static method that passes out
 * an instance of the object (creating it if needed)
 * for use.
 * 
 * Consequences: Essentially a big global so same
 * issues exist as with globals. Also, hides dependencies
 * inside classes that use it. Makes decoupling, unit
 * testing and debugging harder.
 */



class Preferences {
    private static $instance;
    private $properties = array();

    private function __construct() {}

    public static function getInstance() {
        if ((empty(static::$instance))) {
            static::$instance = new Preferences();
        }
        return static::$instance;
    }

    public function getProperty($key) {
        return $this->properties[$key];
    }

    public function setProperty($key, $value) {
        $this->properties[$key] = $value;
    }
}
