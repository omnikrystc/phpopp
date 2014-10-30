<?php
/*
 * Design Pattern: Abstract Factory
 * 
 * Problem: We need to create a family of objects while
 * remaining decoupled.  
 * 
 * Implementation: Essentially extending the factory method
 * to include multiple creator methods within the factory
 * class instead of just the one. 
 * 
 * Consequences: Adding new items to the factory can be 
 * expensive, requiring new concrete implementations for
 * each new product and refactoring of each of the concrete 
 * implementers to add the new item.  
 * 
 * NOTE: It should be obvious that the methods within the
 * various pizza classes would be overridden with more 
 * individualized functions.
 * 
 */

interface PizzaIngredientFactory {
    public function createDough();
    public function createSauce();
    public function createCheese();
    public function createVeggies();
    public function createPepperoni();
    public function createClam();
}

class NewYorkPizzaIngredientFactory implements PizzaIngredientFactory {

    public function createDough() {
        return new ThinCrustDough();
    }    

    public function createSauce() {
        return new MarinaraSauce();
    }
    
    public function createCheese() {
        return new ReggianoCheese();
    }
    
    public function createVeggies() {
        return array(new Garlic(), new Onion(), new Mushroom(), new RedPepper());
    }
    
    public function createPepperoni() {
        return new SlicedPepperoni();
    }
    
    public function createClam() {
        return new FreshClam();
    }
}

class ChicagoPizzaIngredientFactory implements PizzaIngredientFactory {

    public function createDough() {
        return new ThickCrustDough();
    }    

    public function createSauce() {
        return new PlumTomatoSauce();
    }
    
    public function createCheese() {
        return new MozzarellaCheese();
    }
    
    public function createVeggies() {
        return array(new Spinach(), new BlackOlives(), new EggPlant());
    }
    
    public function createPepperoni() {
        return new SlicedPepperoni();
    }
    
    public function createClam() {
        return new FrozenClam();
    }
}

abstract class Pizza {
    protected $factory;
    protected $name;
    protected $sauce;
    protected $veggies = array();
    protected $cheese;
    protected $pepperoni;
    protected $clam;
    
    abstract function prepare();
    
    public function __construct(PizzaIngredientFactory $factory) {
        $this->factory = $factory;
    }
    
    public function bake() {
        print 'Bake for 25 minutes at 350.<br>'.PHP_EOL;
    }
    
    public function cut() {
        print 'Cutting the pizza into diagonal slices.<br>'.PHP_EOL;
    }
    
    public function box() {
        print 'Place in pizza box.<br>'.PHP_EOL;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function __toString() {
        return $this->getName();
    }
}

class CheesePizza extends Pizza {
    
    public function prepare() {
        print 'Preparing...<br>'.PHP_EOL;
        $dough = $this->factory->createDough();
        $sauce = $this->factory->createSauce();
        $cheese = $this->factory->createCheese();
    }
}

class ClamPizza extends Pizza {
    
    public function prepare() {
        print 'Preparing...<br>'.PHP_EOL;
        $dough = $this->factory->createDough();
        $sauce = $this->factory->createSauce();
        $cheese = $this->factory->createCheese();
        $clam = $this->factory->createClam(); 
    }
}

class VeggiePizza extends Pizza {
    
    public function prepare() {
        print 'Preparing...<br>'.PHP_EOL;
        $dough = $this->factory->createDough();
        $sauce = $this->factory->createSauce();
        $cheese = $this->factory->createCheese();
        $veggies = $this->factory->createVeggies(); 
    }
}

class PepperoniPizza extends Pizza {
    
    public function prepare() {
        print 'Preparing...<br>'.PHP_EOL;
        $dough = $this->factory->createDough();
        $sauce = $this->factory->createSauce();
        $cheese = $this->factory->createCheese();
        $pepperoni = $this->factory->createPepperoni(); 
    }
}

abstract class PizzaIngredient {
    
    public function __construct() {
        printf('Created %s<br>'.PHP_EOL, get_class($this));
    }
}

class ThinCrustDough extends PizzaIngredient {}
class ThickCrustDough extends PizzaIngredient {}

class MarinaraSauce extends PizzaIngredient {}
class PlumTomatoSauce extends PizzaIngredient {}

class ReggianoCheese extends PizzaIngredient {}
class MozzarellaCheese extends PizzaIngredient {}

class Garlic extends PizzaIngredient {}
class Onion extends PizzaIngredient {}
class Mushroom extends PizzaIngredient {}
class RedPepper extends PizzaIngredient {}
class BlackOlives extends PizzaIngredient {}
class EggPlant extends PizzaIngredient {}
class Spinach extends PizzaIngredient {}

class SlicedPepperoni extends PizzaIngredient {}

class FreshClam extends PizzaIngredient {}
class FrozenClam extends PizzaIngredient {}
 
abstract class PizzaStore {
    
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

class NewYorkPizzaStore extends PizzaStore {
    
    public function createPizza($type) {
        $pizza = null;
        $factory = new NewYorkPizzaIngredientFactory();
        
        switch (strtolower($type)) {
            case 'cheese':
                $pizza = new CheesePizza($factory);
                $pizza->setName('New York Style Cheese Pizza');
                break;
            case 'clam':
                $pizza = new ClamPizza($factory);
                $pizza->setName('New York Style Clam Pizza');
                break;
            case 'veggie':
                $pizza = new VeggiePizza($factory);
                $pizza->setName('New York Style Veggie Pizza');
                break;
            case 'pepperoni':
                $pizza = new PepperoniPizza($factory);
                $pizza->setName('New York Style Pepperoni Pizza');
                break;
            default:
                break;
        }
        return $pizza;
    }

}

class ChicagoPizzaStore extends PizzaStore {
    
    public function createPizza($type) {
        $pizza = null;
        $factory = new ChicagoPizzaIngredientFactory();
        
        switch (strtolower($type)) {
            case 'cheese':
                $pizza = new CheesePizza($factory);
                $pizza->setName('Chicago Style Cheese Pizza');
                break;
            case 'clam':
                $pizza = new ClamPizza($factory);
                $pizza->setName('Chicago Style Clam Pizza');
                break;
            case 'veggie':
                $pizza = new VeggiePizza($factory);
                $pizza->setName('Chicago Style Veggie Pizza');
                break;
            case 'pepperoni':
                $pizza = new PepperoniPizza($factory);
                $pizza->setName('Chicago Style Pepperoni Pizza');
                break;
            default:
                break;
        }
        return $pizza;
    }

}

