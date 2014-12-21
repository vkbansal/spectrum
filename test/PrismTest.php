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

    public function testLoadLanguages()
    {
        $this->prism->loadLanguages(['markup']);
        $grammar = $this->prism->getGrammar('markup');
        $this->assertArrayHasKey('comment', $grammar);
    }

    public function testLoadAllLanguages()
    {
        $this->prism->loadAllLanguages();
        $grammar = $this->prism->getGrammar();
        $this->assertArrayHasKey('markup', $grammar);
    }
    
}
