<?php

class LanguageTest extends PHPUnit_Framework_TestCase {

    protected $repo;
    
    public function setUp()
    {
    }

    public function testInsertBefore()
    {
        $this->markTestSkipped();
        $this->repo->loadDefinition('markup');
        $this->repo->loadDefinition('css');
        $this->assertTrue(isset($this->repo->getDefinition('markup')['style']));
        $this->assertTrue(isset($this->repo->getDefinition('markup.tag.inside')['style-attr']));
    }

    public function testExtend()
    {
        $this->markTestSkipped();
        $this->repo->loadDefinition('clike');
        $this->repo->loadDefinition('javascript');
        $this->assertTrue(isset($this->repo->getDefinition('javascript')['comment']));
        $this->assertTrue(isset($this->repo->getDefinition('javascript')['regex']));
    }
    
}
