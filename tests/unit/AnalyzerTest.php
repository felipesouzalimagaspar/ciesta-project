<?php
    namespace Test\UnitTest;

    use Code\Type\Analyzer as TypeAnalyzer;
    use Code\Property\Analyzer as PropertyAnalyzer;
    final class AnalyzersTest extends \PHPUnit\Framework\TestCase {
        /**
         * @dataProvider ClassProvider
         */
        public function testGetPropertyAccessWithValidProp(string $property_name, object $instance): void {
            $this->assertTrue(
                PropertyAnalyzer::getPropertyAccessIfExists($property_name, $instance) instanceof \ReflectionProperty
            );
        }
        /**
         * @dataProvider ClassProvider
         */
        public function testGetPropertyAccessWithInvalidProp(string $property_name, object $instance): void {
            $this->assertFalse(
                PropertyAnalyzer::getPropertyAccessIfExists(join('_', ['invalid', $property_name]), $instance)
            );
        }
        /**
         * @dataProvider ClassProvider
         */
        public function testGetAllProperties(string $property_name, object $instance): void {
            $this->assertIsArray(
                PropertyAnalyzer::getAllProperties($instance)
            );
        }        
        /**
         * @dataProvider ScalarValuesProvider
         */
        public function testValueIsScalar(mixed $value): void {
            $this->assertTrue(TypeAnalyzer::isScalar($value));
        }
        /**
         * @dataProvider ArrayValuesProvider
         */
        public function testValueIsArray(mixed $value): void {
            $this->assertTrue(TypeAnalyzer::isArray($value));
        }
        /**
         * @dataProvider ObjectValuesProvider
         */
        public function testValueIsObject(mixed $value): void {
            $this->assertTrue(TypeAnalyzer::isObject($value));
        }
        /**
         * @dataProvider ArrayValuesProvider
         */
        public function testValueNotIsScalar(mixed $value): void {
            $this->assertFalse(TypeAnalyzer::isScalar($value));
        }
        /**
         * @dataProvider ScalarValuesProvider
         */
        public function testValueNotIsArray(mixed $value): void {
            $this->assertFalse(TypeAnalyzer::isArray($value));
        }
        /**
         * @dataProvider ScalarValuesProvider
         */
        public function testValueNotIsObject(mixed $value): void {
            $this->assertFalse(TypeAnalyzer::isObject($value));
        }
        /**
         * @dataProvider ArrayValuesProvider
         */
        public function testTypesMatch(mixed $value): void {
            $this->assertTrue(TypeAnalyzer::typeMatch($value, []));
        }
        /**
         * @dataProvider ArrayValuesProvider
         */
        public function testTypesDiff(mixed $value): void {
            $this->assertFalse(TypeAnalyzer::typeMatch($value, false));
        }
        /**
         * @dataProvider ObjectValuesProvider
         */
        public function testGetClassname(mixed $value): void {
            $this->assertTrue(TypeAnalyzer::getType($value) === get_class($value));
        }
        /**
         * @dataProvider AllTypesProvider
         */
        public function testGetType(mixed $value): void {
            $this->assertIsString(TypeAnalyzer::getType($value));
        }
        public function ClassProvider() : array {
            return [
                "Accessing property by reflection" => ['prop', new class {
                    private bool $prop = false;
                }]
            ];
        }
        public function ScalarValuesProvider() : array {
            return [
                'int value' => [1],
                'bool value' => [false],
                'float value' => [0.1],
                'string value' => ['foo'],
                'nullable value' => [null]
            ];
        }
        public function ArrayValuesProvider() : array {
            return [
                'simple array' => [['foo' => 'bar']],
                'two levels array' => [['foo' => ['bar' => 'baz']]]
            ];
        }
        public function ObjectValuesProvider() : array {
            return [
                'stdClass object' => [(object)['foo' => 'bar']],
                'TestCase object' => [$this]
            ];
        }
        public function ReflectionNamedTypeProvider() : array {
            return [
                'Reflection Named Type' => [(new \ReflectionClass(new class {
                    private bool $prop = false;
                }))->getProperty('prop')->getType()]
            ];
        }
        public function AllTypesProvider() : array {
            return array_merge(
                $this->ScalarValuesProvider(),
                $this->ArrayValuesProvider(),
                $this->ObjectValuesProvider(),
                $this->ReflectionNamedTypeProvider()
            );
        }
    }
