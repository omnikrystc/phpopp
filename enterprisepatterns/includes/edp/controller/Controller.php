<?php
/*
 * Design Pattern: Controller
 * 
 * Problem: Centralizing all request handling to one place
 * in a large or complex system to minimize duplication and
 * make organization/management easier.
 * 
 * Implementation: While the controller itself is pretty simple
 * to effectively separate the tiers a couple helper classes will
 * be needed. (ApplicationHelper, CommandResolver, Command) 
 * 
 * Consequences: There is A LOT of development required to get a
 * functional controller up though much of it is reusable. Also,
 * as mentioned in the Registry Pattern all configuration data is
 * pre-loaded which can have significant overhead unless it is
 * cached or otherwise optimized. 
 * 
 * NOTES: Once you've got a working framework it is very reusable
 * so the turn around is much better on subsequent projects. Also,
 * it is very extensible once it is in place making expanding the
 * system much easier.
 * 
 */
namespace edp\controller;

require_once('ApplicationHelper.php');
require_once('AppController.php');
require_once('includes/edp/registry/RequestRegistry.php');
require_once('includes/edp/registry/ApplicationRegistry.php');
require_once('includes/edp/command/CommandResolver.php');

class Controller {
    private $applicationHelper;
    
    private function __construct() {}
    
    static function run($useCommandResolver = false) {
        $instance = new Controller();
        $instance->init();
        if ($useCommandResolver) {
            $instance->handleRequestWithCommandResolver();
        } else {
            $instance->handleRequest();
        }
    }
    
    function init() {
        $applicationHelper = ApplicationHelper::instance();
        $applicationHelper->init();
    }
    
    function handleRequest() {
        $request = \edp\registry\RequestRegistry::getRequest();
        $controller = \edp\registry\ApplicationRegistry::appController();
        while ($cmd = $controller->getCommand($request)) {
            $cmd->execute($request);
        }
        $this->invokeView($controller->getView($request));
    }
    
    function handleRequestWithCommandResolver() {
        $request = \edp\registry\RequestRegistry::getRequest();
        $resolver = new \edp\command\CommandResolver();
        $command = $resolver->getCommand($request);
        $command->execute($request);
    }
    
    function invokeView($target) {
        include("includes/edp/view/{$target}.php");
    }
} 

