<?php
/*
 * Another example of the decorator design pattern.
 * This one in a more business/practical setting.
 */
 
class RequestHelper {}

abstract class ProcessRequest {
    abstract function process(RequestHelper $request);
}

class MainProcess extends ProcessRequest {

    function process(RequestHelper $request) {
        print __CLASS__.': doing something useful with request.<br>'.PHP_EOL;
    }
}

abstract class DecorateProcess extends ProcessRequest {
    protected $processrequest;
    
    function __construct(ProcessRequest $processrequest) {
        $this->processrequest = $processrequest;
    }
}

class LogRequest extends DecorateProcess {

    function process(RequestHelper $request) {
        print __CLASS__.': logging request.<br>'.PHP_EOL;
        $this->processrequest->process($request);
    }
}

class AuthenticateRequest extends DecorateProcess {

    function process(RequestHelper $request) {
        print __CLASS__.': authenticating request.<br>'.PHP_EOL;
        $this->processrequest->process($request);
    }
}

class StructureRequest extends DecorateProcess {

    function process(RequestHelper $request) {
        print __CLASS__.': structuring request.<br>'.PHP_EOL;
        $this->processrequest->process($request);
    }
}
