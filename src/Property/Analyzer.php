<?php
/**
 * Analyzer class implementation file
 * @package Code\Property
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Property;
/**
 * Analyzer is a class for manipulating attributes using Reflection
 * @final
 */
final class Analyzer {
    /**
     * Gets the ReflectionProperty of an object attribute if it exists
     * @access public
     * @param string $name Variable you want to get (The _ character is disregarded in the variable name)
     * @param object $instance Object for variable access
     * @return \ReflectionProperty|false ReflectionProperty fetched or false if attribute doesn't exist
     */
    public static function getPropertyAccessIfExists(string $name, object $instance) : \ReflectionProperty|false {
        $name = str_replace(["_"], '', strtolower($name));
        foreach ((new \ReflectionClass($instance))->getProperties() as $prop)
            if($name ===  str_replace(["_"], '', strtolower($prop->getName()))) {
                $prop->setAccessible(true);
                return  $prop;
            }
        return false;
    }
    /**
     * Gets the ReflectionProperty of all attributes of an object
     * @access public
     * @param object $instance Object for accessing variables
     * @return array<\ReflectionProperty> ReflectionProperty list of all object attributes
     */
    public static function getAllProperties(object $instance) : array {
        $props = [];
        foreach ((new \ReflectionClass($instance))->getProperties() as $prop) {
            $prop->setAccessible(true);
            $props[] = $prop;
        }
        return $props;
    }
}