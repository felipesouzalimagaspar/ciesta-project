<?php
/**
 * Constructor class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;
#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a constructor method
 */
class Constructor implements MagicallyInvokedMethod {
    /**
     * @var bool Define a constructor method without any attributes
     */
    private bool $noArgs;
    /**
     * @var bool Define a constructor method with all attributes
     */
    private bool $allArgs;
    /**
     * Invokes a method from an instance with the given parameters
     * @access public
     * @param object $instance Object on which the method will be invoked
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function invoke(object $instance, string $name, array $arguments = []) : mixed {
        if($this->noArgs && count($arguments) === 0) return $instance;
        else if($this->allArgs && count($arguments) === count($props = \Code\Property\Analyzer::getAllProperties($instance))) {
            for($i=0;$i<count($arguments);$i++) $props[$i]->setValue($instance, $arguments[$i]);
            return $instance;   
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
        return $name === '__construct';
    }
    /**
     * @access public
     * @param bool $noArgs Constructor method without any attributes
     * @param bool $allArgs Constructor method with all attributes
     */
    public function __construct(bool $noArgs = true, bool $allArgs = true) {
        $this->noArgs = $noArgs;
        $this->allArgs = $allArgs;
    }
}