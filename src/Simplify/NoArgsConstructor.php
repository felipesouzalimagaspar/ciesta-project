<?php
/**
 * NoArgsConstructor class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a constructor method without any attributes
 * @final
 */
final class NoArgsConstructor extends Constructor {
    /**
     * Checks if the called method has the matching signature
     * @access public
     * @param string $name Method name
     * @param array $arguments Method arguments
     * @return bool The called method has the matching signature or not
     */
    public function verifySignature(string $name, array $arguments = []) : bool {
        return $name === '__construct' && count($arguments) === 0;
    }
    public function __construct() {
        parent::__construct();
    }
}