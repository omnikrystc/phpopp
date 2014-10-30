<?php
/*
 * Simple Factory (not a design pattern, just a warm-up)
 * 
 * 
 */

class SimplePizzaStore {
    private $factory;
    
    public function __construct(SimplePizzaFactory $factory) {
        $this->factory = $factory;
    }
    
    public function orderPizza($type) {
        $pizza = $this->factory->createPizza($type);
        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();
        return $pizza;
    }
}

class SimplePizzaFactory {

    public function createPizza($type) {
        switch (strtolower($type)) {
            case 'cheese':
                return new SimpleCheesePizza();
            case 'pepperoni':
                return new SimplePepperoniPizza();
            case 'clam':
                return new SimpleClamPizza();
            case 'veggie':
                return new SimpleVeggiePizza();
            default:
                return null;
        }
    }
}

abstract class SimplePizza {
    protected $type;

    public function getType() {
        return $this->type;
    }
    
    public function prepare() {
        print "<div>Preparing a {$this->type} pizza...</div>".PHP_EOL;
    }
    
    public function bake() {
        print "<div>Baking a {$this->type} pizza...</div>".PHP_EOL;
    }
    
    public function cut() {
        print "<div>Cutting a {$this->type} pizza...</div>".PHP_EOL;
    }
    
    public function box() {
        print "<div>Boxing a {$this->type} pizza...</div>".PHP_EOL;
    }
}
    

class SimpleCheesePizza extends SimplePizza {
    protected $type = 'cheese';
} 

class SimplePepperoniPizza extends SimplePizza {
    protected $type = 'pepperoni';
} 

class SimpleClamPizza extends SimplePizza {
    protected $type = 'clam';
} 

class SimpleVeggiePizza extends SimplePizza {
    protected $type = 'veggie';
} 
