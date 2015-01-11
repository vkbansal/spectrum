<?php
use VKBansal\Prism\Language\Mapper;

class MapperTest extends PHPUnit_Framework_TestCase {

    protected $mapper;

    public function setUp()
    {
        $this->mapper = new Mapper();
    }

    public function testGetDefinitionClasses()
    {
        $classes = $this->mapper->getDefinitionClasses();

        $this->assertTrue(is_array($classes));
        foreach ($classes as $key => $value) {
            $this->assertStringStartsWith('VKBansal\Prism\Components\Definition', $value);
        }
    }

    public function testGetMap()
    {
        $map = $this->mapper->getMap();

        $this->assertTrue(is_array($map));
        $this->assertTrue(is_array($map['map']));
        $this->assertTrue(is_array($map['aliases']));
        $this->assertTrue(is_array($map['defaults']));
    }    
}
