<?php
/*
 * 
 * Command Pattern extending the abstract parent
 * 
 */
namespace edp\command;

require_once('Command.php');
require_once('includes/edp/controller/Request.php');

class DefaultCommand extends Command {
    
    function doExecute(\edp\controller\Request $request) {
        $request->addFeedback('Welcome to EDP');
    }
}
