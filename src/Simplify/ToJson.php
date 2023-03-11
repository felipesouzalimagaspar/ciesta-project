<?php
/**
 * ToJson class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a ToJson method
 * @final
 */
final class ToJson implements MagicallyInvokedMethod {
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
            try{ $tmp[$prop->getName()] = $this->resolv($prop->getValue($instance)); }
            catch(\TypeError $te) { continue; }
        return json_encode($tmp, JSON_UNESCAPED_UNICODE);
    }
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return bool The called method has the matching signature or not
     */
    public function verifySignature(string $name, array $arguments = []) : bool {
        return in_array($name, ['toJson', 'toJson']) && count($arguments) === 0;
    }
    /**
     * Verify and parse object properties to json format
     * @access private
     * @param mixed $prop Object property
     * @return mixed The value for use in json format
     * @throws TypeError When property is not serializable this error is throwable
     */
    private function resolv(mixed $prop) : mixed {
        if($prop instanceof \JsonSerializable) {
            return $prop->jsonSerialize();
        } else if(
            \Code\Type\Analyzer::isScalar($prop) || 
            (\Code\Type\Analyzer::isObject($prop) && !($prop instanceof \Closure))
        ) {
            return $prop;
        } else if(\Code\Type\Analyzer::isArray($prop) || $prop instanceof \iterable) {
            $tmp = [];
            foreach ($prop as $key => $value) {
                try { $tmp[$key] = $this->resolv($value);}
                catch(\TypeError $te) { continue; }
            }
            return $tmp;
        }
        throw new \TypeError(\Code\Type\Analyzer::getType($prop) . ' is not serializable');
    }
}