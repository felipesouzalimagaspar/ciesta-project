<?php
/**
 * Simplify class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code;

use Code\Simplify\MagicallyInvokedMethod;
use Code\Simplify\Solver;
/**
 * Simplified object abstraction
 * @abstract
 */
abstract class Simplify implements \JsonSerializable {
    /**
     * Magic method to call any action
     * @access public 
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function __call(string $name, array $arguments = []) : mixed {
        return $this->getMethodSolver()->solve($this, $name, $arguments);
    }
    /**
     * Get all methods available to this object
     * @access private
     * @return Solver Discover, validate and execute the desired method call
     */
    private function getMethodSolver() : Solver {
        $methods = [];
        foreach((new \ReflectionClass($this))->getAttributes() as $method) {
            $method = $method->newInstance();
            if($method instanceof MagicallyInvokedMethod) $methods[] = $method;
        }
        return new Solver(...$methods);
    }
    /**
     * @access public 
     * @param mixed ...$params Variables passed by parameter on instanciation
     */
    public function __construct(mixed ...$params) {
        return $this->__call('__construct', func_get_args());
    }
    /**
     * Method to called in json serializable object
     * @access public 
     * @return mixed Object data in json serializable format
     */
    public function jsonSerialize() : mixed  {
        try {
            return json_decode($this->__call('toJson'), true);
        } catch(\Throwable $t) {
            return (object) [];
        }
    }
    /**
     * Magic method __toString
     * @access public 
     * @return string Object data in string format
     */
    public function __toString() {
        return $this->__call('toString');
    }
}

