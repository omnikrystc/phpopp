<?php
/*
 * A helper for the views.
 * 
 */
namespace edp\view;

require_once('includes/edp/registry/RequestRegistry.php');

class VH {
    static function getRequest() {
        return \edp\registry\RequestRegistry::getRequest();
    }
}
?>