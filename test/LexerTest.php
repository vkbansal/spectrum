<?php
use VKBansal\Spectrum\Lexer;

class LexerTest extends PHPUnit_Framework_TestCase
{
    protected $generator;

    public function setUp(){
        $grammar = [
            'rest' => [
                'token1' => [
                    'pattern' => '/dummy text/',
                    'inside' => [
                        'token2' => '/text/'
                    ]
                ]
            ]
        ];
        $this->generator = new Lexer('dummy text', $grammar, 'lang');
    }

    public function testTokenize(){
        $nodes = $this->generator->tokenize();
        $token = $nodes[0];
        $this->assertInstanceOf('VKBansal\Spectrum\Token', $token);
        $this->assertInstanceOf('VKBansal\Spectrum\Token', $token->getContent()[1]);
    }

    public function testToNodes()
    {
        // $this->markTestSkipped();
        $document = new DOMDocument();

        $prism = $this->getMockBuilder('VKBansal\Spectrum\Spectrum')->getMock();

        $prism->method('getDocument')->will($this->returnValue($document));

        $this->generator->tokenize();
        $node = $this->generator->toNodes($prism);
        $html = $node[0]->ownerDocument->saveHTML($node[0]);

        $this->assertEquals('<span class="token token1">dummy <span class="token token2">text</span></span>', $html);

    }
}
