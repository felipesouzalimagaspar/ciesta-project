<?php
/**
 * Solver class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;
/**
 * Discover, validate and execute the desired method call
 * @final
 */
final class Solver {
    /**
     * @var array<MagicallyInvokedMethod> List of available methods
     */
    private array $declared_methods = [];
    /**
     * @access public
     * @param MagicallyInvokedMethod ...$methods List of available methods
     */
    public function __construct(MagicallyInvokedMethod ...$methods) {
        $this->declared_methods = $methods;
    }
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param object $instance Object for method invocation
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     * @throws \Error Error when method is not defined
     */
    public function solve(object $instance, string $name, array $arguments = []) : mixed {
        foreach($this->declared_methods as $method)
            if($method->verifySignature($name, $arguments))
                return $method->invoke($instance, $name, $arguments);
        throw self::UndefinedMethodError($instance, $name, $arguments);
    }
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param object $instance Object for method invocation
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return Error Create an error when method is undefined
     */
    public static function UndefinedMethodError(object $instance, string $name, array $arguments) : \Error {
        return new \Error("Call to undefined method ".get_class($instance)."::{$name}(".join(", ", $arguments).")");
    }
}
