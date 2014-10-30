<?php
/*
 * Design Pattern: Observer
 * 
 * Problem: Decoupling client classes (observers) from a central
 * class (subject) to make both troubleshooting and reuse of the
 * code easier.
 * 
 * Implementation: Provide an Observable interface that can attach,
 * detach and notify Observers and an Observer interface that
 * can accept updates. This allows an observer to register to 
 * receive updates while knowing little about the object it is
 * observing (and vice versa).
 * 
 * Consequences: The first portion passes the observable blindly to
 * the observer which can be problematic in more complex systems.
 * At the bottom is a tighter coupled version where the Observer is
 * expected to maintain a reference to its Observable in order to
 * check for a match when update is called. Also, because the observer 
 * is external to the object it observes it might require exposing 
 * more about the class being observed or adding additional functionality 
 * to allow the observer to do its job.
 * 
 * NOTES:
 * 
 */

interface Observable {
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

class Login implements Observable {
    private $observers = array();
    private $status;
    
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    
    function attach(Observer $observer) {
        $this->observers[] = $observer;
    }
    
    function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function($a) use ($observer) {
            return (!($a === $observer));
        });
    }

    function notify() {
        foreach($this->observers as $observer) {
            $observer->update($this);
        }
    }
    
    function handleLogin($user, $pass, $ip) {
        $isvalid = false;
        switch(rand(1,3)) {
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $isvalid = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $isvalid = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $isvalid = false;
                break;
        }
        $this->notify();
        return $isvalid;
    } 
    
    function setStatus($status, $user, $ip) {
        $this->status = array($status, $user, $ip);
    }
    
    function getStatus() {
        return $this->status;
    }
}

interface Observer {
    function update(Observable $observable);
}

class RawSecurityMonitor implements Observer {
    function update(Observable $observable) {
        $status = $observable->getStatus();
        if ($status[0] == Login::LOGIN_WRONG_PASS) {
            print __CLASS__.": sending mail to sysadmin, failed login ($status[1])!<br>".PHP_EOL;
        }
    }
}
 
abstract class LoginObserver implements Observer {
    private $login;

    abstract function doUpdate(Login $login);

    function __construct(Login $login) {
        $this->login = $login;
        $login->attach($this);
    }
    
    function update(Observable $observable) {
        if ($observable === $this->login) {
            $this->doUpdate($observable);
        }
    }
}

class SecurityMonitor extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        if ($status[0] == Login::LOGIN_WRONG_PASS) {
            print __CLASS__.": sending mail to sysadmin, failed login ($status[1])!<br>".PHP_EOL;
        }
    }
}

class GeneralLogger extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        print __CLASS__.": adding login information to log ($status[1])!<br>".PHP_EOL;
    }
}

class PartnershipTool extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        // check IP and set cookie if it is listed
        print __CLASS__.": creating cookie for ($status[2])!<br>".PHP_EOL;
    }
}