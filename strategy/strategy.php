<?php
/*
 * Design Pattern: Strategy (also, policy)
 *  
 * Problem: A family of classes use a set of interchangeable algorithms
 * between them that need to be set at runtime. Using inheritance would
 * mean many classes and lots of code duplication.
 * 
 * Implementation: Implement the shared algorithms against a shared 
 * interface so that they can be set at runtime as needed.
 * 
 * Consequences: Everything has to be passed around, even for simple
 * consumers, which can add overhead.
 * 
 * NOTES:
 * 
 */
 
abstract class Question {
    protected $prompt;
    protected $marker;

    function __construct($prompt, Marker $marker) {
        $this->marker = $marker;
        $this->prompt = $prompt;
    }

    function mark($response) {
        return $this->marker->mark($response);
    }
}

class TextQuestion extends Question {
    // do text question things
}

class AVQuestion extends Question {
    // do av question things
}

abstract class Marker {
    protected $test;
    
    abstract function mark($response);

    function __construct($test) {
        $this->test = $test;
    }
    
}


 
/* this one uses a parse sample and the interpreter
 * pattern demo to expose a simple logic language.
 * It is stubbed here to keep on topic.
 */
class MarkLogicMarker extends Marker {
    private $engine;
    
    function __construct($test) {
        parent::__construct($test);
        //$this->engine = new MarkParse($test);
    }
    
    function mark($response) {
        //return $this->engine->evaluate($response);
        // dummy return value
        return true;
    }
}

class MatchMarker extends Marker {
    function mark($response) {
        return ($this->test == $response);
    }
}

class RegexpMarker extends Marker {
    function mark($response) {
        return (preg_match($this->test, $response));
    }
}
