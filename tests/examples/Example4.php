<?php
#[
    \Code\Simplify\Constructor(true, true),
    \Code\Simplify\Getters,
    \Code\Simplify\Setters,
    \Code\Simplify\ToString,
    \Code\Simplify\ToJson
]
final class Example4 extends \Code\Simplify {
    private ?int $id = 1;
    private string $name = 'foo';
    private array $numbers= [];
    private \Example1 $var1;
    private \Example2 $var2;
    private object $object;
    private \Closure $func;
    public function __construct() {
        $this->numbers = [
            'int' => [0,1,2,3,4,5,6,7,8,9],
            'float' => [0.1, 0.2, 0.3,0.4,0.5,0.6,0.7,0.8,0.9,1.0],
            'closure' => function () { return false; }
        ];
        $this->var1 = new \Example1;
        $this->var2 = new \Example2(1,'foo');
        $this->object = new class {private int $id = 1;};
        $this->func = function () { return false; };
    }
}