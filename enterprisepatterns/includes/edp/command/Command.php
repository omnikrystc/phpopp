<?php
/*
 * the Command Pattern is already covered in an individual
 * demo so not going to copy and paste it here. 
 * 
 * This is the abstract class and the default command. The
 * others are all loaded by name when they are needed. 
 * 
 */
namespace edp\command;

require_once('includes/edp/controller/Request.php');

abstract class Command {

    private static $STATUS_STRINGS = array(
        'CMD_DEFAULT' => 0,
        'CMD_OK' => 1,
        'CMD_ERROR' => 2,
        'CMD_INSUFFICIENT_DATA' => 3
    );
    
    private $status = 0;

    abstract function doExecute(\edp\controller\Request $request);

    final function __construct() {}
    
    function execute(\edp\controller\Request $request) {
        $this->status = $this->doExecute($request);
        $request->setCommand($this);
    }
    
    function getStatus() {
        return $this->status;
    }
    
    static function statuses($status = 'CMD_DEFAULT') {
        if (empty($status)) {
            $status = 'CMD_DEFAULT';
        }
        return self::$STATUS_STRINGS[$status];
    }
} 
