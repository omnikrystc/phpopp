<?php
/*
 * Design Pattern: Decorator
 * 
 * Problem: Using inheritance can lead to a large complicated tree
 * of classes which inevitably results in code duplication.   
 * 
 * Implementation: Alternately the decorator class forms a flexible
 * chain of classes by keeping an instance of their parent's class
 * and calling the same operation on them and so on down the line.  
 * 
 * Consequences: Can be confusing and complex/large classes need
 * lots of hand-off code or to utilize things like __call which
 * makes them more prone to errors and not as transparent (via
 * reflection and the like).
 * 
 * NOTE: 
 * 
 */
 
abstract class Tile {
    abstract function getWealthFactor();
}
 
class Plains extends Tile {
    private $wealthFactor = 2;

    function getWealthFactor() {
        return $this->wealthFactor;
    }
}

abstract class TileDecorator extends Tile {
    protected $tile;
    
    function __construct(Tile $tile) {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator {
    function getWealthFactor() {
        return $this->tile->getWealthFactor()+2;
    }
}


class PollutionDecorator extends TileDecorator {
    function getWealthFactor() {
        return $this->tile->getWealthFactor()-4;
    }
}
