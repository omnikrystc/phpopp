<?php
/*
 * Design Pattern: Facade
 * 
 * Problem: Interfacing with 3rd party modules, non-OO code or
 * even between your own subsystems can lead to unwanted 
 * coupling and make for painful debugging. Also, a pain to
 * change out should you want to use something different. 
 * 
 * Implementation: Basically a class to wrap the offending
 * code/functionality to provide a single clean interface
 * to it. 
 * 
 * Consequences: It is easy to get carried away and add
 * layers of abstraction. 
 * 
 * NOTE: 
 * 
 */

class ProductFacade {
    private $products = array();

    function __construct($file) {
        $this->file = $file;
        $this->compile();
    }
    
    private function compile() {
        $lines = getProductFileLines($this->file);
        foreach($lines as $line) {
            $id = getIDFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromID($id, $name);
        }
    }
    
    function getProducts() {
        return $this->products;
    }
    
    function getProduct($id) {
        if (is_set($this->products[$id])) {
            return $this->products[$id];
        }
        return null;
    }
}


