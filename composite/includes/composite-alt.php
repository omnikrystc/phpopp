<?php

/*
 * An example of how to get around leaves having to support add/remove 
 * functionality. Some consider the division of add/remove into a different
 * interface part of the pattern even though it wasn't originally that way.
 */ 

abstract class AltUnit {
    function getComposite() {
        return null;
    }
    
    abstract function bombardStrength();
}

class CompositeUnit extends AltUnit {
    private $units = array();
    
    function getComposite() {
        return $this;
    }
    
    protected function units() {
        return $this->units;
    }
    
    function addUnit(AltUnit $unit) {
        if (in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }
    
    function removeUnit(AltUnit $unit) {
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

class UnitScript {
    static function joinExisting(AltUnit $newUnit, AltUnit $occupyingUnit) {
        $comp;
        if (!is_null($comp = $occupyingUnit->getComposite())) {
            $comp->addUnit($newUnit);
        } else {
            $comp = new Army();
            $comp->addUnit($occupyingUnit);
            $comp->addUnit($newUnit);
        }
        return $comp;
    }
}

/*
 * An example of how this method can be difficult to expand. For example creating 
 * troop carriers that are limited in what they can carry. We are now having to
 * start tightly coupling things again to make this work. Doesn't mean this cannot
 * be used only that thought has to be given to how/when to implement it. 
 */


class AltArcher extends AltUnit {
    
    function bombardStrength() {
        return 4;
    }    
}

class AltLaserCannon extends AltUnit {
    
    function bombardStrength() {
        return 44;
    }    
}

class AltCavalry extends AltUnit {
    
    function bombardStrength() {
        return 0;
    }    
}

class MyClass extends AltUnit {
    function bombardStrength() {
        return 0;
    }
        
} 

class TroopCarrier extends CompositeUnit {
        
    function addUnit(AltUnit $unit) {
        if ($unit instanceof AltCavalry) {
            throw new UnitException("Can't get a horse on the vehicle!");
        }
        parent::addUnit($unit);
    }
    
    function bombardStrength() {
        return 0;
    }
}
