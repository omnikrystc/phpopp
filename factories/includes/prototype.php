<?php
/*
 * Design Pattern: Prototype
 * 
 * Problem: The Abstract Factory is too rigid and would require
 * too much work to support a large/diverse selection.
 * 
 * Implementation: Instead of having concrete implementers in
 * our factory pass the objects in during initialization and
 * clone them when they are requested.  
 * 
 * Consequences: Must prime the factory for it to work and must
 * ensure all instances properly support being cloned, deep 
 * cloning where needed.
 * 
 * NOTE: This is also useful in cases where implementation is 
 * expensive (loading data, parsing a large buffer, etc)
 * but needs to be reused.
 * 
 */

class Resource {
    protected $abundance = 1;    
}

class Oak {}
class Game {}
class River {}

class Sea {
    protected $navigability = 1;
    
    public function __construct($navigability = 0) {
        if ($navigability) {
            $this->navigability = $navigability;
        }
    }
}

class EarthSea extends Sea {}
class MarsSea extends Sea {
    protected $navigability = 4;
}

class Forest {
    protected $resource;
    
    public function __construct($resource = null) {
        $this->resource = $resource;
    }
    
    public function __clone() {
        if ($this->resource) {
            $this->resource = clone $this->resource;
        }
    }
}

class EarthForest extends Forest {}
class MarsForest extends Forest {}

class Plains {}
class EarthPlains extends Plains {}
class MarsPlains extends Plains {}
 
class TerrainFactory {
    private $sea;
    private $forest;
    private $plains;
    
    public function __construct($sea, $forest, $plains) {
        $this->sea = $sea;
        $this->forest = $forest;
        $this->plains = $plains;
    }
    
    public function getSea() {
        return clone $this->sea;
    }
    
    public function getForest() {
        return clone $this->forest;
    }
    
    public function getPlains() {
        return clone $this->plains;
    }
}
