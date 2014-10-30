<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Patterns: Visitor</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/notvisitor.php');

print '<h1>Without the visitor pattern...</h1>'.PHP_EOL;
$main_army = new notvisitor\Army();
$main_army->addUnit(new notvisitor\Archer());
$main_army->addUnit(new notvisitor\LaserCanonUnit());
$sub_army=new notvisitor\Army();
$sub_army->addUnit(new notvisitor\Cavalry());
$sub_army->addUnit(new notvisitor\Archer());
$main_army->addUnit($sub_army);
$main_army->addUnit(new notvisitor\Cavalry());
print $main_army->textDump();
print '<hr>';
$main_army->removeUnit( $sub_army );
print $main_army->textDump();


require_once('includes/visitor.php');

print '<h1>Using the visitor pattern...</h1>'.PHP_EOL;
$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCanonUnit());
$main_army->addUnit(new Cavalry());
$sub_army=new Army();
$sub_army->addUnit(new Cavalry());
$sub_army->addUnit(new Archer());
$main_army->addUnit($sub_army);
$main_army->addUnit(new Cavalry());

print '<h3>Text Dump Visitor</h3>';
$textdump = new TextDumpArmyVisitor();
$main_army->accept($textdump);
print $textdump->getText();

print '<h3>Tax Collector Visitor</h3>';
$taxcollector = new TaxCollectionVisitor();
$main_army->accept( $taxcollector );
print $taxcollector->getReport();
print "TOTAL: ";
print $taxcollector->getTax()."\n";


?>
    </body>
</html>
