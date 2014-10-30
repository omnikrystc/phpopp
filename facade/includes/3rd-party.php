<?php
/* Example of a third party plugin/module/etc
 * that you might have to deal with. Calling it
 * directly would mean sloppy code and deep
 * coupling that would be hard to maintain.
 */
 
function getProductFileLines($file) {
    return file($file);
}

function getProductObjectFromId($id, $productname) {
    // some kind of database lookup
    return new Product($id, $productname);
}

function getNameFromLine($line) {
    if (preg_match('/.*-(.*)\s\d+/', $line, $array)) {
        return $array[1];
    }
}

function getIDFromLine($line) {
    if (preg_match('/^(\d{1,3})-/', $line, $array)) {
        return $array[1];
    }
}

class Product {
    public $id;
    public $name;
    
    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
}


