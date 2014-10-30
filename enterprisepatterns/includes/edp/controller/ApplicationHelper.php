<?php
/*
 * Not a design pattern as much as just a helper class
 *   
 */
namespace edp\controller;

require_once('AppController.php');
require_once('ControllerMap.php');
require_once('includes/edp/exception/AppException.php');
require_once('includes/edp/registry/ApplicationRegistry.php');

class ApplicationHelper {
    private static $instance = null;
    private $config = 'data/edp_config.xml';
    
    private function __construct() {}
    
    static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    function init() {
        $dsn = \edp\registry\ApplicationRegistry::getDSN();
        if (!is_null($dsn)) {
            return;
        }
        $this->getOptions();
    }
    
    private function getOptions() {
        $this->ensure(file_exists($this->config), 'Could not find options file');
        $options = simplexml_load_file($this->config);
        $dsn = (string)$options->dsn;
        $this->ensure($dsn, 'No DSN found');
        \edp\exception\ApplicationRegistry::setDSN($dsn);
        $map = new ControllerMap(); 

        foreach ($options->control->view as $default_view) {
            $stat_str = trim($default_view['status']); 
            $status = \edp\command\Command::statuses( $stat_str );
            $map->addView('default', $status, (string)$default_view);
        }

        foreach ($options->control->command as $command_view) {
            $command = trim((string)$command_view['name']);
            if ($command_view->classalias) {
                $classroot = trim((string)$command_view->classalias['name']);
                $map->addClassroot($command, $classroot);
            }
            if ($command_view->view) {
                $view =  trim((string)$command_view->view);
                $forward = trim((string)$command_view->forward);
                $map->addView($command, 0, $view);
                if ($forward) {
                    $map->addForward($command, 0, $forward);
                }
                foreach($command_view->status as $command_view_status) {
                    $view =  trim((string)$command_view_status->view);
                    $forward = trim((string)$command_view_status->forward);
                    $stat_str = trim($command_view_status['value']); 
                    $status = \edp\command\Command::statuses($stat_str);
                    if ($view) {
                        $map->addView($command, $status, $view);
                    }
                    if ($forward) {
                        $map->addForward($command, $status, $forward);
                    }
                }
            }
        }
        \edp\registry\ApplicationRegistry::setControllerMap($map);
    }
    
    private function ensure($expr, $message) {
        if (!$expr) {
            throw new \edp\exception\AppException($message);
        }
    }
}
