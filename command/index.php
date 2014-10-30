<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Pattern: Command</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/command.php');

print '<h1>Command pattern...</h1>';

$controller = new Controller();
$context = $controller->getContext();
$context->addParam('action', 'feedback' );
$context->addParam('email', 'bob@bob.com' );
$context->addParam('topic', 'my brain' );
$context->addParam('msg', 'all about my brain' );
$controller->process();
print $context->getError();


?>
    </body>
</html>
