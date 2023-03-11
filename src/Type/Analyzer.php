<?php
/**
 * Analyzer class implementation file
 * @package Code\Type
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Type;
/**
 * Analyzer is an inspection class for primitive types and classes in PHP
 * @final
 */
final class Analyzer {
    /**
     * Checks the type or class name of a variable
     * @access public
     * @param mixed $param Variable you want to find out the type
     * @param bool $returnClassName Flag to enable/disable inspection of class names
     * @return string Type or class name of the informed variable
     */
    public static function getType(mixed $param, bool $returnClassName = true) : string {
        if($param instanceof \ReflectionNamedType) {
            return $param->getName();
        } else if($returnClassName && gettype($param) === 'object') {
            return get_class($param);
        }else {
            $format = fn (string $t) => $t === 'boolean' ? 'bool' : ($t === 'integer' ? 'int' : ($t === 'double' ? 'float' : ($t === 'NULL' ? 'null' : $t)));
            return $format(gettype($param));
        }
    }
    /**
     * Check if a variable is scalar (bool, int, float, string, or null)
     * @access public
     * @param mixed $param Variable you want to find out the type
     * @return bool The variable is or is not scalar
     */
    public static function isScalar(mixed $param) : bool { return in_array(self::getType($param), ['bool', 'int', 'float', 'string', 'null']); }
    /**
     * Checks if a variable is an array
     * @access public
     * @param mixed $param Variable you want to find out the type
     * @return bool The variable is or is not array
     */
    public static function isArray(mixed $param) : bool { return self::getType($param) === 'array'; }
    /**
     * Checks if a variable is an object
     * @access public
     * @param mixed $param Variable you want to find out the type
     * @return bool The variable is or is not object
     */
    public static function isObject(mixed $param) : bool { return self::getType($param, false) === 'object'; }
    /**
     * Checks if two variables are of the same type
     * @access public
     * @param mixed $param1 Variable 1 you want to compare type
     * @param mixed $param2 Variable 2 you want to compare type
     * @return bool The variables are or are not of the same type
     */
    public static function typeMatch(mixed $param1, mixed $param2) : bool { return self::getType($param1) === self::getType($param2); }
}