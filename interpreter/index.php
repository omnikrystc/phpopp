<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Pattern: Interpreter</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/interpreter.php');

$context = new InterpreterContext();

$literal = new LiteralExpression('four');
$literal->interpret($context);
print "<h3>Literal: {$context->lookup($literal)}</h3>".PHP_EOL;

$myvar = new VariableExpression('input', 'four');
$myvar->interpret($context);
print "<h3>Input variable: {$context->lookup($myvar)}</h3>".PHP_EOL;

$newvar = new VariableExpression('input');
$newvar->interpret($context);
print "<h3>Retrieve variable: {$context->lookup($newvar)}</h3>".PHP_EOL;

$myvar->setValue('five');
$myvar->interpret($context);
print "<h3>Change variable: {$context->lookup($myvar)}</h3>".PHP_EOL;
print "<h3>Retrieve variable: {$context->lookup($newvar)}</h3>".PHP_EOL;

$input = new VariableExpression('input');
$statement = new BooleanOrExpression(new EqualsExpression($input, new LiteralExpression('four')), 
                                        new EqualsExpression($input, new LiteralExpression('4')));

foreach(array('four', '4', '52') as $value) {
    $input->setValue($value);
    print "<div>$value: ";
    $statement->interpret($context);
    if ($context->lookup($statement)) {
        print 'top marks!</div>'.PHP_EOL;
    } else {
        print 'dunce hat!</div>'.PHP_EOL;
    }
}

?>        
    </body>
</html>
