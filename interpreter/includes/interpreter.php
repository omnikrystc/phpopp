<?php
/*
 * Design Pattern: Interpreter
 * 
 * Problem: Provide a flexible "language" for the end user. Useful for
 * simple scripting, templating, questionnair type applications, etc.
 * 
 * Implementation: Build discrete expressions that work against a central 
 * context class for storage and coordination of parts.
 * 
 * Consequences: For any nontrivial "language" the number of classes will
 * be significant. Also, this only handles processing not parsing. A
 * system capable of parsing and using your "language" still needs
 * to be realized.
 * 
 * NOTES: 
 * 
 */
 
abstract class Expression {
    private static $keycount = 0;
    private $key;
    
    abstract function interpret(InterpreterContext $context);
    
    function getKey() {
        if (!isset($this->key)) {
            self::$keycount++;
            $this->key = self::$keycount;
        }
        return $this->key;
    }
}

class LiteralExpression extends Expression {
    private $value;
    
    function __construct($value) {
        $this->value = $value;
    }
    
    function interpret(InterpreterContext $context) {
        $context->replace($this, $this->value);
    }
}

class InterpreterContext {
    private $expressionstore = array();
    
    function replace(Expression $expression, $value) {
        $this->expressionstore[$expression->getKey()] = $value;
    }
    
    function lookup(Expression $expression) {
        return $this->expressionstore[$expression->getKey()];
    }
}

class VariableExpression extends Expression {
    private $name;
    private $value;
    
    function __construct($name, $value = null) {
        $this->name = $name;
        $this->value = $value;
    }
    
    function interpret(InterpreterContext $context) {
        if (!is_null($this->value)) {
            $context->replace($this, $this->value);
            $this->value = null;
        }
    }
    
    function setValue($value) {
        $this->value = $value;
    }
    
    function getKey() {
        return $this->name;
    } 
}

abstract class OperatorExpression extends Expression {
    protected $left_op;
    protected $right_op;
    
    protected abstract function doInterpret(InterpreterContext $context, $result_left, $result_right);

    function __construct($left_op, $right_op) {
        $this->left_op = $left_op;
        $this->right_op = $right_op;
    }
    
    function interpret(InterpreterContext $context) {
        $this->left_op->interpret($context);
        $this->right_op->interpret($context);
        $result_left = $context->lookup($this->left_op);
        $result_right = $context->lookup($this->right_op);
        $this->doInterpret($context, $result_left, $result_right);
    }
    
}

class EqualsExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_left, $result_right) {
        $context->replace($this, $result_left === $result_right);
    }
}

class BooleanOrExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_left, $result_right) {
        $context->replace($this, $result_left || $result_right);
    }
}

class BooleanAndExpression extends OperatorExpression {
    protected function doInterpret(InterpreterContext $context, $result_left, $result_right) {
        $context->replace($this, $result_left && $result_right);
    }
}


