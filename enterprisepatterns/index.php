<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/edp/controller/Controller.php'); 
\edp\controller\Controller::run(true);
?>