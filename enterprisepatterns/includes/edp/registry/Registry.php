<?php
/*
 * Design Pattern: Registry
 * 
 * Problem: Need a way to persist objects/data across the
 * layers of an enterprise application. 
 * 
 * Implementation: Essentially a specialized Singleton.
 * The specifics will vary depending on the scope of the
 * registry.
 * 
 * Consequences: Same issues you have with a Singleton or
 * Globals. Couples code, hides relationships, etc. Also,
 * there can be a significant performance issue initializing
 * a registry so it is best to implement some type of caching. 
 * 
 * NOTES: The upside with testing/debugging is it is trivial 
 * to stub/mock this class and it is centralized. There are 
 * different scopes when talking PHP/web development 
 * (application, session, request). To keep things simple it 
 * is best to keep them in separate Registry implementations.
 * 
 */
namespace edp\registry;

abstract class Registry {
    abstract protected function get($key);
    abstract protected function set($key, $value);
}
