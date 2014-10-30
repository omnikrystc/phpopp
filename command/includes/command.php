<?php
/*
 * Design Pattern: Command
 *
 * Problem: A request handler (web page for example) needs to
 * delegate tasks to a tier focused on application logic to
 * minimize redundancy and keep the system well organized and
 * easy to maintain.
 *
 * Implementation: A class the implements the execute method is
 * the core of the system. With the context typically being passed
 * in via a parameter. This can be via an implemented  interface or
 * extended base class (providing common functionality).
 *
 * Consequences: Requires more organization/overhead than the
 * other patterns but this is really where you start to get into
 * enterprise patterns so it is to be expected.
 *
 * NOTES: Most of the files are setup/support but they are
 * required to really see what the Command pattern is all
 * about.
 *
 */

class CommandNotFoundException extends Exception {}

class CommandFactory {
    private static $dir = 'includes/commands';

    static function getCommand($action = 'Default') {
        if (preg_match('/\W/', $action)) {
            throw new Exception('illegal characters in action');
        }
        $class = UCFirst(strtolower($action)) . 'Command';
        $file = self::$dir.DIRECTORY_SEPARATOR."$class.php";
        if (!file_exists($file)) {
            throw new CommandNotFoundException("could not find '$file'");
        }
        require_once ($file);
        if (!class_exists($class)) {
            throw new CommandNotFoundException("no '$class' class located");
        }
        $cmd = new $class();
        return $cmd;
    }

}

class Controller {
    private $context;
    function __construct() {
        $this -> context = new CommandContext();
    }

    function getContext() {
        return $this -> context;
    }

    function process() {
        $cmd = CommandFactory::getCommand($this->context->get('action'));
        if (!$cmd->execute($this->context)) {
            // handle failure
        } else {
            // success
            // dispatch view
        }
    }

}

// ------------- helper stuff
class User {
    private $name;
    function __construct($name) {
        $this -> name = $name;
    }

}

class Registry {
    static function getMessageSystem() {
        return new MessageSystem();
    }

    static function getAccessManager() {
        return new AccessManager();
    }

}

class MessageSystem {
    function send($mail, $msg, $topic) {
        print "sending $mail: $topic: $msg<br>";
        return true;
    }

    function getError() {
        return "move along now, nothing to see here";
    }

}

class AccessManager {
    function login($user, $pass) {
        $ret = new User($user);
        return $ret;
    }

    function getError() {
        return "move along now, nothing to see here";
    }

}

class CommandContext {
    private $params = array();
    private $error = "";

    function __construct() {
        $this -> params = $_REQUEST;
    }

    function addParam($key, $val) {
        $this -> params[$key] = $val;
    }

    function get($key) {
        return $this -> params[$key];
    }

    function setError($error) {
        $this -> error = $error;
    }

    function getError() {
        return $this -> error;
    }

}
?>
