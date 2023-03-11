<?php
/**
 * Setters class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a setter method
 * @final
 */
final class Setters implements MagicallyInvokedMethod {
    /**
     * @var string Define a default prefix in method name
     */
    private string $prefix;
    /**
     * @var bool Allows chaining of calls to setter methods
     */
    private bool $chain;
    /**
     * Invokes a method from an instance with the given parameters
     * @access public
     * @param object $instance Object on which the method will be invoked
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function invoke(object $instance, string $name, array $arguments = []) : mixed {
        if($prop = \Code\Property\Analyzer::getPropertyAccessIfExists(str_replace($this->prefix, "", $name), $instance)) {
            if($prop->getType() === null || ($arguments[0] === null) || (\Code\Type\Analyzer::typeMatch($arguments[0], $prop->getType()))) {
                $prop->setValue($instance, $arguments[0]);
                return ($this->chain) ? $instance : null;
            }else throw new \TypeError("Typed property ".get_class($instance)."::{$prop->getName()} must be {$prop->getType()}, ".\Code\Type\Analyzer::getType($arguments[0])." used");
        }
        throw \Code\Simplify\Solver::UndefinedMethodError($instance, $name, $arguments);
    }
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return bool The called method has the matching signature or not
     */
    public function verifySignature(string $name, array $arguments = []) : bool {
        return (strpos($name, $this->prefix) === 0 && count($arguments) === 1);
    }
    /**
     * @access public
     ** @param string $prefix Define a default prefix in method name
     *  @param string $chain Allows chaining of calls to setter methods
     */
    public function __construct(string $prefix = 'set', bool $chain = true) {
        $this->prefix = $prefix;
        $this->chain = $chain;
    }
}