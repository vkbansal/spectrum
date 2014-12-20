<?php
use VKBansal\Prism\Token;
use VKBansal\Prism\Node;

class NodeTest extends PHPUnit_Framework_TestCase {

    protected $node;

    public function setUp()
    {
        $token = new Token('comment', 'content', 'sugesstion');
        $this->node = new Node($token, 'dummy');
    }

    public function testGetLanguage()
    {
        $this->assertEquals('dummy', $this->node->getLanguage());
    }

    public function testGetDOMNode()
    {
        $node = $this->node->getDOMNode();
        $this->assertInstanceOf('DOMNode',$node);
    }
    
}
