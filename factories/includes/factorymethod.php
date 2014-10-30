<?php
/*
 * Design Pattern: Factory Method
 * 
 * Problem: Decoupling code to make it more flexible
 * means not directly instantiating objects with new. 
 * 
 * Implementation: Code to an interface splitting the
 * creator and product class and extending abstract
 * classes of each. 
 * 
 * Consequences: Significant duplication in the creators
 * and structure can get complex as the pattern is extended
 * to support more options (see abstract factory). 
 * 
 * NOTE: It should be obvious that the methods within the
 * various pizza classes would be overridden with more 
 * individualized functions. Also, the createPizza method
 * in the factories are the only place that directly reference
 * the concrete classes making expansion fairly easy and
 * transparent to existing code.
 * 
 */
 
abstract class MethodPizzaStore {
    
    abstract public function createPizza($type);

    public function orderPizza($type) {
        // moved createPizza to abstracted function in class
        $pizza = $this->createPizza($type);
        $pizza->prepare();
        $pizza->bake();
        $pizza->cut();
        $pizza->box();
        return $pizza;
    }
}

abstract class MethodPizza {
    protected $style;
    protected $type;

    public function getType() {
        return $this->type;
    }
    
    public function getStyle() {
        return $this->style;
    }
    
    public function prepare() {
        print "<div>Preparing a {$this->style} style {$this->type} pizza...</div>".PHP_EOL;
    }
    
    public function bake() {
        print "<div>Baking a {$this->style} style {$this->type} pizza...</div>".PHP_EOL;
    }
    
    public function cut() {
        print "<div>Cutting a {$this->style} style {$this->type} pizza...</div>".PHP_EOL;
    }
    
    public function box() {
        print "<div>Boxing a {$this->style} style {$this->type} pizza...</div>".PHP_EOL;
    }
}
 
class MethodNewYorkPizzaStore extends MethodPizzaStore {

    public function createPizza($type) {
        switch (strtolower($type)) {
            case 'cheese':
                return new MethodNewYorkCheesePizza();
            case 'pepperoni':
                return new MethodNewYorkPepperoniPizza();
            case 'clam':
                return new MethodNewYorkClamPizza();
            case 'veggie':
                return new MethodNewYorkVeggiePizza();
            default:
                return null;
        }
    }
}
 
class MethodChicagoPizzaStore extends MethodPizzaStore {

    public function createPizza($type) {
        switch (strtolower($type)) {
            case 'cheese':
                return new MethodChicagoCheesePizza();
            case 'pepperoni':
                return new MethodChicagoPepperoniPizza();
            case 'clam':
                return new MethodChicagoClamPizza();
            case 'veggie':
                return new MethodChicagoVeggiePizza();
            default:
                return null;
        }
    }
}

class MethodNewYorkCheesePizza extends MethodPizza {
    protected $style = 'New York';
    protected $type = 'cheese';
} 

class MethodNewYorkPepperoniPizza extends MethodPizza {
    protected $style = 'New York';
    protected $type = 'pepperoni';
} 

class MethodNewYorkClamPizza extends MethodPizza {
    protected $style = 'New York';
    protected $type = 'clam';
} 

class MethodNewYorkVeggiePizza extends MethodPizza {
    protected $style = 'New York';
    protected $type = 'veggie';
} 

class MethodChicagoCheesePizza extends MethodPizza {
    protected $style = 'Chicago';
    protected $type = 'cheese';
} 

class MethodChicagoPepperoniPizza extends MethodPizza {
    protected $style = 'Chicago';
    protected $type = 'pepperoni';
} 

class MethodChicagoClamPizza extends MethodPizza {
    protected $style = 'Chicago';
    protected $type = 'clam';
} 

class MethodChicagoVeggiePizza extends MethodPizza {
    protected $style = 'Chicago';
    protected $type = 'veggie';
} 
