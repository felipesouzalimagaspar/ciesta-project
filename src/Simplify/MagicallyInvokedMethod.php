<?php
/**
 * MagicallyInvokedMethod interface implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;
/**
 * MagicallyInvokedMethod is an interface for methods invoked with a little bit of magic
 */
interface MagicallyInvokedMethod {
    /**
     * Invokes a method from an instance with the given parameters
     * @access public
     * @param object $instance Object on which the method will be invoked
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function invoke(object $instance, string $name, array $arguments = []) : mixed;
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return bool The called method has the matching signature or not
     */
    public function verifySignature(string $name, array $arguments = []) : bool;
}