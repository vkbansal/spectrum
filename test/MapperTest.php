<?php
use VKBansal\Prism\Language\Mapper;

class MapperTest extends PHPUnit_Framework_TestCase {

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
        $map = Mapper::getMap();
        $this->assertTrue(is_array($map));
    }    
}
