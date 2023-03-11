<?php
/**
 * Equals class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a equals method
 * @final
 */
final class Equals implements MagicallyInvokedMethod {
    /**
     * Invokes a method from an instance with the given parameters
     * @access public
     * @param object $instance Object on which the method will be invoked
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function invoke(object $instance, string $name, array $arguments = []) : mixed {
        if(
            \Code\Type\Analyzer::typeMatch($instance, $arguments[0])
            && count($otherProps = \Code\Property\Analyzer::getAllProperties($arguments[0]))
            === count($myProps = \Code\Property\Analyzer::getAllProperties($instance))
        ) {
            for($i=0;$i<count($arguments);$i++)
                if(!($otherProps[$i]->getValue($arguments[0]) === $myProps[$i]->getValue($instance))) {
                    return false;
                }
            return true;   
        } else return false;
    }
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return bool The called method has the matching signature or not
     */
    public function verifySignature(string $name, array $arguments = []) : bool {
        return $name === 'equals' && count($arguments) === 1;
    }
}