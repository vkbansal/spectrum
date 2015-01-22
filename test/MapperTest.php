<?php
use VKBansal\Prism\Language\Mapper;

class MapperTest extends PHPUnit_Framework_TestCase {

    protected $mapper;

    public function testGetDefinitionClasses()
    {
        $classes = Mapper::getDefinitionClasses();

        $this->assertTrue(is_array($classes));
        foreach ($classes as $key => $value) {
            $this->assertStringStartsWith('VKBansal\Prism\Components\Definition', $value);
        }
    }

    public function testGetMap()
    {
        list($map, $aliases, $defaults) = Mapper::getMap();

        $this->assertTrue(is_array($map));
        $this->assertTrue(is_array($aliases));
        $this->assertTrue(is_array($defaults));
    }    
}
