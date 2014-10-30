<?php
/*
 * Design Pattern: Visitor
 * 
 * Problem: Adding new functions/algorithms to existing collection/composite 
 * structure without having to modify the objects it contains. 
 * 
 * Implementation: The visitor implements multiple functions to cover all of the 
 * objects in the structure and determines which to run based on the input.
 * 
 * Consequences: Because the visitor is external to the object it 
 * visits it might require exposing more about the class being visited or
 * adding additional functionality to allow the visitor to do its job.
 * 
 * NOTES:
 * 
 */

class UnitException extends Exception {}

class TextDumpArmyVisitor extends ArmyVisitor {
    private $text = '';

    function visit(Unit $node) {
        $ret = '';
        $ret .= str_repeat('&nbsp;', 4*$node->getDepth());
        $ret .= get_class($node).', bombard: ';
        $ret .= $node->bombardStrength().'<br>';
        $this->text .= $ret;
    }

    function getText() {
        return $this->text;
    }
}

class TaxCollectionVisitor extends ArmyVisitor {
    private $due = 0;
    private $report = '';

    function visit(Unit $node) {
        $this->levy($node, 1);
    }

    function visitArcher(Archer $node) {
        $this->levy($node, 2);
    }

    function visitCavalry(Cavalry $node) {
        $this->levy($node, 3);
    }

    function visitTroopCarrierUnit(TroopCarrierUnit $node) {
        $this->levy($node, 5);
    }

    private function levy(Unit $unit, $amount) {
        $this->report .= 'Tax levied for '.get_class($unit);
        $this->report .= ": $amount<br>".PHP_EOL;
        $this->due += $amount;
    }

    function getReport() {
        return $this->report;
    }

    function getTax() {
        return $this->due;
    }
}

abstract class ArmyVisitor  {
    abstract function visit(Unit $node);

    function visitArcher(Archer $node) {
        $this->visit($node);
    }
    function visitCavalry(Cavalry $node) {
        $this->visit($node);
    }

    function visitLaserCanonUnit(LaserCanonUnit $node) {
        $this->visit($node);
    }

    function visitTroopCarrierUnit(TroopCarrierUnit $node) {
        $this->visit($node);
    }

    function visitArmy(Army $node) {
        $this->visit($node);
    }
}

abstract class Unit {
    protected $depth = 0;

    function getComposite() {
        return null;
    }
    
    protected function setDepth($depth) {
        $this->depth=$depth;
    }
    function getDepth() {
        return $this->depth;
    }

    abstract function bombardStrength();

    function accept(ArmyVisitor $visitor) {
        $method = 'visit'.get_class($this);
        $visitor->$method($this);
    }
}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }

}

class Cavalry extends Unit {
    function bombardStrength() {
        return 2;
    }
}

class LaserCanonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

abstract class CompositeUnit extends Unit {
    private $units = array();

    function getComposite() {
        return $this;
    }

    function units() {
        return $this->units;
    }

    function removeUnit(Unit $unit) {
        $units = array();
        foreach ($this->units as $thisunit) {
            if ($unit !== $thisunit) {
                $units[] = $thisunit;
            }
        }
        $this->units = $units;
    }
/*
    function accept( ArmyVisitor $visitor ) {
        $method = "visit".get_class( $this );
        $visitor->$method( $this );
        foreach ( $this->units as $thisunit ) {
            $thisunit->accept( $visitor );
        }
    }
*/

    function accept(ArmyVisitor $visitor) {
        parent::accept($visitor);
        foreach ($this->units as $thisunit) {
            $thisunit->accept($visitor);
        }
    }

    function addUnit(Unit $unit) {
        foreach ($this->units as $thisunit) {
            if ($unit === $thisunit) {
                return;
            }
        }
        $unit->setDepth($this->depth + 1);
        $this->units[] = $unit;
    }
}

class TroopCarrier extends CompositeUnit {

    function addUnit(Unit $unit) {
        if ($unit instanceof Cavalry ) {
            throw new UnitException('Can\'t get a horse on the vehicle');
        }
        parent::addUnit($unit);
    }

    function bombardStrength() {
        return 0;
    }
}

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach($this->units() as $unit) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}
