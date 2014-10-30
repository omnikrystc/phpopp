<?php
/*
 * Design Pattern: Composite
 * 
 * Problem: Managing groups of objects can get complicated. Even 
 * worse if some of the objects are containers themselves.   
 * 
 * Implementation: Create containers that can be treated as if they
 * were instances of the objects they contain by inheriting the same
 * functionality in both the single instance and collection.
 * 
 * Consequences: Methods that don't apply to the individual (add/remove
 * for example) are still inherited in order to maintain the shared 
 * functionality. This means testing what type an instance is before
 * performing certain actions or complicating the base class by adding
 * special handlers. (see the CompositeUnit, TroopCarrier and UnitScript 
 * classes and POPP ~181-184 for details)
 * 
 * NOTE: 
 * 
 */

class UnitException extends Exception {}
 
abstract class Unit {
    abstract function bombardStrength();

    function addUnit(Unit $unit) {
        throw new UnitException(get_class($this)." is a leaf");
    }
    
    function removeUnit(Unit $unit) {
        throw new UnitException(get_class($this)." is a leaf");
    }
    
}

class Army extends Unit {
    private $units = array();
    
    function addUnit(Unit $unit) {
        if (in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }
    
    function removeUnit(Unit $unit) {
        $units = array();
        foreach ( $this->units as $thisunit ) {
            if ( $unit !== $thisunit ) {
                $units[] = $thisunit;
            }
        }
        $this->units = $units;
    }
    
    function bombardStrength() {
        $strength = 0;
        foreach($this->units as $unit) {
            $strength += $unit->bombardStrength();
        }
        return $strength;
    }
}

class Archer extends Unit {
    
    function bombardStrength() {
        return 4;
    }    
}

class LaserCannon extends Unit {
    
    function bombardStrength() {
        return 44;
    }    
}
