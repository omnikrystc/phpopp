<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>Design Patterns: Factories</title>
    </head>
    <body>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// pizza types to make demoing easier
$types = array('cheese', 'clam', 'pepperoni', 'veggie');


// simple factory method, still need to create the factory!!!
require_once('includes/simplefactory.php');

print '<h1>Simple Factory (just a warm-up):</h1>'.PHP_EOL;

$simple_store = new SimplePizzaStore(new SimplePizzaFactory());
foreach($types as $type) {
    $pizza = $simple_store->orderPizza($type);
    print "<h3>My pizza: {$pizza->getType()}</h3><hr>".PHP_EOL;
}

// factory method, now individual classes hide the factory creation
require_once('includes/factorymethod.php');

print '<h1>Factory Method (design pattern):</h1>'.PHP_EOL;

$method_store = new MethodNewYorkPizzaStore();
foreach($types as $type) {
    $pizza = $method_store->orderPizza($type);
    print "<h3>My pizza: {$pizza->getType()}</h3><hr>".PHP_EOL;
}

$method_store = new MethodChicagoPizzaStore();
foreach($types as $type) {
    $pizza = $method_store->orderPizza($type);
    print "<h3>My pizza: {$pizza->getType()}</h3><hr>".PHP_EOL;
}

// abstract factory, one more step and we can abstract families of objects in one go
require_once('includes/abstractfactory.php');

print '<h1>Abstract Factory (design pattern):</h1>'.PHP_EOL;

$store = new ChicagoPizzaStore();
foreach($types as $type) {
    $pizza = $store->orderPizza($type);
    print "<h3>{$pizza->getName()}</h3><hr>".PHP_EOL;
}

$store = new NewYorkPizzaStore();
foreach($types as $type) {
    $pizza = $store->orderPizza($type);
    print "<h3>{$pizza->getName()}</h3><hr>".PHP_EOL;
}


// prototype, one more step and we can dynamically craft families on the fly
require_once('includes/prototype.php');

print '<h1>Prototype (design pattern):</h1>'.PHP_EOL;

// earth like planet
print '<h3>Earth:</h3>'.PHP_EOL;
$planet = new TerrainFactory(new EarthSea(), new EarthForest(new Oak()), new EarthPlains());
print_r($planet->getSea());
print '<br>'.PHP_EOL;
print_r($planet->getForest());
print '<br>'.PHP_EOL;
print_r($planet->getPlains());
print '<br>'.PHP_EOL;

// mars like planet
print '<h3>Mars:</h3>'.PHP_EOL;
$planet = new TerrainFactory(new MarsSea(), new MarsForest(new River()), new MarsPlains());
print_r($planet->getSea());
print '<br>'.PHP_EOL;
print_r($planet->getForest());
print '<br>'.PHP_EOL;
print_r($planet->getPlains());
print '<br>'.PHP_EOL;

// hybrid planet
print '<h3>Hybrid:</h3>'.PHP_EOL;
$planet = new TerrainFactory(new MarsSea(12), new EarthForest(), new MarsPlains());
print_r($planet->getSea());
print '<br>'.PHP_EOL;
print_r($planet->getForest());
print '<br>'.PHP_EOL;
print_r($planet->getPlains());
print '<br>'.PHP_EOL;

?>
    </body>
</html>
