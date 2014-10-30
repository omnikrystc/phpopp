<?php
/*
 * 
 * Command Pattern extending the abstract parent
 * 
 */
namespace edp\command;

require_once('Command.php');
require_once('includes/edp/controller/Request.php');

class DefaultCommandForCommandResolver extends Command {
    
    function doExecute(\edp\controller\Request $request) {
        $request->addFeedback('Welcome to EDP (using CommandResolver)!');
        include('includes/edp/view/main.php');
    }
}
