<?php
namespace edp\controller;

require_once('ControllerMap.php');
require_once('Request.php');
require_once('includes/edp/exception/AppException.php');
require_once('includes/edp/command/Command.php');
require_once('includes/edp/command/DefaultCommand.php');

class AppController {
    private static $base_cmd;
    private static $default_cmd;
    private $controllerMap;
    private $invoked = array();

    function __construct(ControllerMap $map) {
        $this->controllerMap = $map;
        if (!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass('\edp\command\Command');
            self::$default_cmd = new \edp\command\DefaultCommand();
        }
    }

    function getView(Request $req) {
        $view = $this->getResource($req, 'View');
        return $view;
    }

    function getForward(Request $req) {
        $forward = $this->getResource($req, 'Forward');
        if ($forward) {
            $req->setProperty('cmd', $forward);
        }
        return $forward;
    }

    private function getResource(Request $req, $res) {
        $cmd_str = $req->getProperty('cmd');
        $previous = $req->getLastCommand();
        $status = $previous->getStatus();
        if (!$status) {
            $status = 0; 
        }
        $acquire = "get{$res}";
        $resource = $this->controllerMap->$acquire($cmd_str, $status);
        if (!$resource) {
            $resource = $this->controllerMap->$acquire($cmd_str, 0);
        }
        if (!$resource) {
            $resource = $this->controllerMap->$acquire('default', $status);
        }
        if (!$resource) {
            $resource = $this->controllerMap->$acquire('default', 0);
        }
        return $resource;
    }

    function getCommand(Request $req) {
        $previous = $req->getLastCommand();
        if (!$previous) {
            $cmd = $req->getProperty('cmd');
            if ( ! $cmd ) {
                $req->setProperty('cmd', 'default');
                return  self::$default_cmd;
            }
        } else {
            $cmd = $this->getForward($req);
            if (!$cmd) {
                 return null; 
            }
        }
        $cmd_obj = $this->resolveCommand($cmd);
        if (!$cmd_obj) {
            throw new \edp\exception\AppException("couldn't resolve '$cmd'"); 
        }
        $cmd_class = get_class($cmd_obj);
        if (isset($this->invoked[$cmd_class])) {
            throw new \edp\exception\AppException('circular forwarding');
        }
        $this->invoked[$cmd_class] = 1;
        return $cmd_obj;
    }

    function resolveCommand($cmd) {
        $classroot = $this->controllerMap->getClassroot($cmd);
        $filepath = "edp/command/{$classroot}.php";
        $classname = "\\woo\\command\\{$classroot}";
        if (file_exists($filepath)) {
            require_once($filepath);
            if (class_exists($classname)) {
                $cmd_class = new \ReflectionClass($classname);
                if ($cmd_class->isSubClassOf(self::$base_cmd)) {
                    return $cmd_class->newInstance();
                }
            }
        }
        return null;
    }
}
