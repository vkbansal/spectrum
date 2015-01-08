<?php
use VKBansal\Prism\Token\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
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
        $this->generator = new Generator('dummy text', $grammar, 'lang');
    }

    public function testGenerate(){
        $nodes = $this->generator->generate();
        $token = $nodes[0];
        $this->assertInstanceOf('VKBansal\Prism\Token\Token', $token);
        $this->assertInstanceOf('VKBansal\Prism\Token\Token', $token->content[1]);
    }

    public function testToNodes()
    {
        $this->markTestSkipped();
        $document = new DOMDocument();

        $this->generator->generate();
        $node = $this->generator->toNodes($document);
        $html = $node[0]->ownerDocument->saveHTML($node[0]);

        $this->assertEquals('<span class="token token1">dummy <span class="token token2">text</span></span>', $html);

    }
}
