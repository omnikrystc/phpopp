<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Patterns: Decorator</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_log(E_ALL);

print '<h2>Simple tile example of a decorator in action...</h2>'.PHP_EOL;

require_once('includes/decorator.php');

$tile = new Plains();
print "<h3>Plains: {$tile->getWealthFactor()}</h3>".PHP_EOL;

$diamonds = new DiamondDecorator($tile);
print "<h3>Plains w/ Diamonds: {$diamonds->getWealthFactor()}</h3>".PHP_EOL;

$pollution = new PollutionDecorator($diamonds);
print "<h3>Plains w/ Diamonds and pollution: {$pollution->getWealthFactor()}</h3>".PHP_EOL;

print '<h2>Basic processing example of a decorator in action...</h2>'.PHP_EOL;

require_once('includes/decorator-alt.php');

$request = new AuthenticateRequest(new StructureRequest(new LogRequest(new MainProcess())));

$request->process(new RequestHelper());

?>        
    </body>
</html>
