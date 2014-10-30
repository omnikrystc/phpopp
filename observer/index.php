<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Patterns: Observer</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/observer.php');

print '<h1>Raw observer that passes the observable blindly.</h1>'.PHP_EOL;
$login = new Login();
$security = new RawSecurityMonitor();
$login->attach($security);
print '<ul>'.PHP_EOL;
$users = array('Billy', 'Mary', 'Tom', 'Dave', 'Sue');
foreach($users as $user) { 
   print "<li>$user:";
   $login->handleLogin($user, 'secret', '1.1.1.1');
   print '</li>'.PHP_EOL;	
}
$login->detach($security);

print '<h1>Targetted observers that check the observable before acting.</h1>'.PHP_EOL;
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);
foreach($users as $user) { 
   print "<li>$user:<br>";
   $login->handleLogin($user, 'secret', '1.1.1.1');
   print '</li>'.PHP_EOL;   
}

?>
    </body>
</html>
