<?php
/*
 * This highlights the need for something like the
 * Visitor pattern. We've added textDump to our
 * Composite pattern directly. This complicates
 * the Composite pattern making it less portable and
 * makes the functionality itself not at all reusable.
 * This is made even worse if we needed to add more 
 * features after these objects were in use. A visitor
 * pattern would allow addition of new abilities/features
 * without compromising existing systems.
 *
 */
namespace notvisitor;

class UnitException extends \Exception {}

abstract class Unit {

    abstract function bombardStrength();
    
    function getComposite() {
        return null;
    }

    function textDump($depth = 0) {
        $ret = '';
        $ret .= str_repeat('&nbsp;', 4*$depth);
        $ret .= get_class($this).', bombard: ';
        $ret .= $this->bombardStrength().'<br>';
        return $ret;
    }

    function unitCount() {
        return 1;
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

    function addUnit(Unit $unit) {
        if (in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }

    function unitCount() {
        $ret = 0;
        foreach ($this->units as $unit) {
            $ret += $unit->unitCount(); 
        }
        return $ret;
    }

    function textDump($num = 0) {
        $ret = parent::textDump($num);
        foreach ($this->units as $unit) {
            $ret .= $unit->textDump($num + 1); 
        }
        return $ret;
    }

}


class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
    function unitCount() {
        return 1;
    }
}

class Cavalry extends Unit {
    function bombardStrength() {
        return 0;
    }
}

class LaserCanonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

class TroopCarrier extends CompositeUnit {

    function addUnit(Unit $unit) {
        if ($unit instanceof Cavalry) {
            throw new UnitException('Can\'t get a horse on the vehicle');
        }
        parent::addUnit($unit);
    }

    function bombardStrength() {
        return 0;
    }
}

// end previous code

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach($this->units() as $unit) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

?>