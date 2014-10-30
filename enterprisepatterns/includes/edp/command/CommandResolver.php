<?php 
/*
 * A factory for Command patterns (see Command Pattern's
 * individual project)
 * 
 */
namespace edp\command;

require_once('Command.php');
require_once('DefaultCommandForCommandResolver.php');
require_once('includes/edp/controller/Request.php');

class CommandResolver {
    private static $base_cmd = null;
    private static $default_cmd = null;
    
    function __construct() {
        if (is_null(self::$base_cmd)) {
            self::$base_cmd = new \ReflectionClass('\edp\command\Command');
            self::$default_cmd = new DefaultCommandForCommandResolver();
        }
    }
    
    function getCommand(\edp\controller\Request $request) {
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;
        if (!$cmd) {
            return self::$default_cmd;
        }
        $cmd = str_replace(array('.', $sep), '', $cmd);
        $filepath = "includes{$sep}ebp{$sep}{$cmd}.php";
        $classname = '\edp\command\\'.$cmd;
        if (class_exists($classname)) {
            $cmd_class = new \ReflectionClass($classname);
            if ($cmd_class->isSubClassOf(self::$base_command)) {
                return $cmd_class->newInstance();
            } else {
                $request->addFeedback("command '$cmd' is not a Command");
            }
        }
        $request->addFeedback("command '$cmd' not found");
        return clone self::$default_cmd;
    }
}
