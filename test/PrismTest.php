<?php
use VKBansal\Prism\Prism;
use VKBansal\Prism\Node;

class PrismTest extends PHPUnit_Framework_TestCase {

    protected $prism;

    public function setUp()
    {
        $this->prism = new Prism();
    }

    public function testloadDefaultLanguages()
    {
        $this->prism->loadDefaultLanguages();
        $grammar = $this->prism->getGrammar();
        $this->assertArrayHasKey('markup', $grammar);
        $this->assertArrayHasKey('clike', $grammar);
    }

    public function testAddLanguages()
    {
        $this->prism->addLanguages(['markup']);
        $grammar = $this->prism->getGrammar('markup');
        $this->assertArrayHasKey('comment', $grammar);
    }

    public function testAddAllLanguages()
    {
        $this->prism->addAllLanguages();
        $grammar = $this->prism->getGrammar();
        $this->assertArrayHasKey('markup', $grammar);
    }
    
}
