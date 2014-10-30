<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Patterns: Facade</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_log(E_ALL);

require_once('includes/3rd-party.php');
require_once('includes/facade.php');

print '<h1>Sloppy, tightly coupled (assuming this is scattered around a much larger project), non-OO code...</h1>';
$lines = getProductFileLines('products.txt');
$products = array();
foreach($lines as $line) {
    $id = getIDFromLine($line);
    $name = getNameFromLine($line);
    $products[$id] = getProductObjectFromID($id, $name);
}
print '<ul>'.PHP_EOL;
foreach($products as $product) {
    print "<li>{$product->id}: {$product->name}</li>".PHP_EOL;
}
print '</ul><hr>'.PHP_EOL;

print '<h1>Using a facade to provide one point of contact...</h1>';
$facade = new ProductFacade('products.txt');
print '<ul>'.PHP_EOL;
foreach($facade->getProducts() as $product) {
    print "<li>{$product->id}: {$product->name}</li>".PHP_EOL;
}
print '</ul><hr>'.PHP_EOL;

?>        
    </body>
</html>
