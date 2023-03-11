<?php
/**
 * Getters class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a getter method
 * @final
 */
final class Getters implements MagicallyInvokedMethod {
    /**
     * @var string Define a default prefix in method name
     */
    private string $prefix;
    /**
     * Invokes a method from an instance with the given parameters
     * @access public
     * @param object $instance Object on which the method will be invoked
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function invoke(object $instance, string $name, array $arguments = []) : mixed {
        if($prop = \Code\Property\Analyzer::getPropertyAccessIfExists(str_replace($this->prefix, "", $name), $instance))
            return $prop->getValue($instance);
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
        return (strpos($name, $this->prefix) === 0 && count($arguments) === 0);
    }
    /**
     * @access public
     * @param string $prefix Define a default prefix in method name
     */
    public function __construct(string $prefix = 'get') { $this->prefix = $prefix; }
}