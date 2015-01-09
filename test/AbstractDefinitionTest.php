<?php

class AbstractDefinitionTest extends PHPUnit_Framework_TestCase {

    protected $def;
    protected $prism;

    public function setUp()
    {
        $this->def = $this->getMockForAbstractClass('VKBansal\Prism\Language\AbstractDefinition');
        $this->prism = $this->getMockBuilder("VKBansal\Prism\Prism")->getMock();
        $this->def->injectPrism($this->prism);
        $lang =& $this->prism->getDefinition();
        $lang['mylang'] = [
            'token1' => 'default1',
            'token2' => 'default2',
        ];
    }

    public function testInsertBefore()
    {
        dump($this->prism->getDefinition());
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
