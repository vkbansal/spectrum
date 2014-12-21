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
        $case = ['lorem ipsum', $this->token, null];
        $nodes = Token::detokenize($case, 'dummy');

        $this->assertInstanceOf('DOMText', $nodes[0]);
        $this->assertInstanceOf('DOMNode', $nodes[1]);
    }

    public function testTokenize()
    {
        $grammar = [
            "tag"=> [
                "pattern"=> "/<\/?[\w:-]+\s*(?:\s+[\w:-]+(?:=(?:(\"|')(\\\\?[\w\W])*?\g{1}|[^\s'\">=]+))?\s*)*\/?>/i",
                "inside"=> [
                    "tag"=> [
                        "pattern"=> "/^<\/?[\w:-]+/i",
                        "inside"=> [
                            'punctuation'=> "/^<\/?/",
                            'namespace'=> "/^[\w-]+?:/"
                        ]
                    ],
                    'attr-value'=> [
                        "pattern" => "/=(?:('|\")[\w\W]*?(\g{1})|[^\s>]+)/i",
                        "inside" => [
                            'punctuation'=> "/=|>|\"/"
                        ]
                    ],
                    'punctuation'=> "/\/?>/",
                    'attr-name'=> [
                        "pattern"=> "/[\w:-]+/",
                        "inside"=> [
                            "namespace"=> "/^[\w-]+?:/"
                        ]
                    ]
                ]
            ]
        ];

        $text = "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"/>";

        $token = Token::tokenize($text, $grammar);

        $this->assertInstanceOf('VKBansal\Prism\Token', $token[0]);
    }
    
}
