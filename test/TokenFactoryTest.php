<?php
use VKBansal\Prism\Token\TokenFactory;

class TokenFactoryTest extends PHPUnit_Framework_TestCase
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
        $this->generator = new TokenFactory('dummy text', $grammar, 'lang');
    }

    public function testGenerate(){
        $nodes = $this->generator->makeTokens();
        $token = $nodes[0];
        $this->assertInstanceOf('VKBansal\Prism\Token\Token', $token);
        $this->assertInstanceOf('VKBansal\Prism\Token\Token', $token->content[1]);
    }

    public function testToNodes()
    {
        // $this->markTestSkipped();
        $document = new DOMDocument();

        $prism = $this->getMockBuilder('VKBansal\Prism\Prism')->getMock();

        $prism->method('getDocument')->will($this->returnValue($document));

        $this->generator->makeTokens();
        $node = $this->generator->toNodes($prism);
        $html = $node[0]->ownerDocument->saveHTML($node[0]);

        $this->assertEquals('<span class="token token1">dummy <span class="token token2">text</span></span>', $html);

    }
}
