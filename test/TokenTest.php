<?php
use VKBansal\Prism\Token;

class TokenTest extends PHPUnit_Framework_TestCase {

    protected $token;

    public function setUp()
    {
        $this->token = new Token('type', 'content');
    }

    public function testDetokenize()
    {
        $case = ['lorem ipsum', $this->token];
        $nodes = Token::Detokenize($case, 'dummy');

        $this->assertInstanceOf('DOMText', $nodes[0]);
        $this->assertInstanceOf('DOMNode', $nodes[1]);
    }

    public function testTokenize()
    {
        
    }
    
}
