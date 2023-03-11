<?php
/**
 * AllArgsConstructor class implementation file
 * @package Code\Simplify
 * @author Felipe Gaspar <felipesouzalimagaspar@gmail.com>
 */
declare(strict_types=1);
namespace Code\Simplify;

#[\Attribute(\Attribute::TARGET_CLASS)]
/**
 * Implements a constructor method with all attributes in the order of their declaration
 * @final
 */
final class AllArgsConstructor extends Constructor {
    public function __construct() {
        parent::__construct(false, true);
    }
}