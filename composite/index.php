<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Pattern: Composite</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('includes/composite.php');

// main army
$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannon());

print "<h3>Main army bombard strength: {$main_army->bombardStrength()}</h3>".PHP_EOL;

// sub army
$sub_army = new Army();
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

print "<h3>Sub army bombard strength: {$sub_army->bombardStrength()}</h3>".PHP_EOL;

// merged armies
$main_army->addUnit($sub_army);

print "<h3>Merged army bombard strength: {$main_army->bombardStrength()}</h3>".PHP_EOL;

// remove sub army
$main_army->removeUnit($sub_army);

print "<h3>Sub army removed bombard strength: {$main_army->bombardStrength()}</h3>".PHP_EOL;

require_once('includes/composite-alt.php');


$carrier = new TroopCarrier();

print '<h3>Trying to add Cavalry to TroopCarrier...</h3>'.PHP_EOL;
try {
    $carrier->addUnit(new AltCavalry());
} catch (Exception $e) {
    print "<h5>ERROR: {$e->getMessage()}</h5>".PHP_EOL;
} 

print '<h3>OK now adding normal troops...</h3>'.PHP_EOL;
$carrier->addUnit(new AltArcher());
$carrier->addUnit(new AltLaserCannon());
print "<h3>Carrier still has no bombard strength with an army loaded: {$carrier->bombardStrength()}</h3>".PHP_EOL;

?>        
    </body>
</html>
