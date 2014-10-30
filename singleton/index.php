<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Patterns: Singleton</title>
    </head>
    <body>
<?php
// flip on debugging  
ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('includes/singleton.php');


$prefs = Preferences::getInstance();
$prefs->setProperty('name', 'Thomas');
unset($prefs);

// somewhere else in the project
$prefs1 = Preferences::getInstance();
$prefs1->setProperty('games', array('Tic Tac Toe', 'Chess', 'Checkers', 'Othello', 'Match Four', 'Jarts'));
unset($prefs1);

// somewhere else in the project
$prefs2 = Preferences::getInstance();
print "<h1>{$prefs2->getProperty('name')}</h1>".PHP_EOL;
print '<ul>'.PHP_EOL;
foreach($prefs2->getProperty('games') as $value) {
    print "<li>$value</li>".PHP_EOL;
}
print '</ul>'.PHP_EOL;

?>		
    </body>
</html>
