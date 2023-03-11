<?php
/**
 * ToString class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a ToString method
 * @final
 */
final class ToString implements MagicallyInvokedMethod {
    /**
     * Invokes a method from an instance with the given parameters
     * @access public
     * @param object $instance Object on which the method will be invoked
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return mixed The return varies according to the invoked method
     */
    public function invoke(object $instance, string $name, array $arguments = []) : mixed {
        $tmp = [];
        foreach (\Code\Property\Analyzer::getAllProperties($instance) as $prop)
            $tmp[] = join("=", [$prop->getName(),var_export($prop->getValue($instance), true)]);
        return join('', [join('', [get_class($instance), '=(']), join("&", $tmp), ')']);
    }
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return bool The called method has the matching signature or not
     */
    public function verifySignature(string $name, array $arguments = []) : bool {
        return in_array($name, ['__toString', 'toString']) && count($arguments) === 0;
    }
}