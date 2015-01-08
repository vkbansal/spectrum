<?php
use VKBansal\Prism\Token\Token;
use VKBansal\Prism\AssetManager;

class TokenTest extends PHPUnit_Framework_TestCase
{
    protected $doc;

    public function setUp()
    {
        $this->doc = new \DOMDocument();
    }

    public function testStringToken()
    {
        $this->markTestSkipped();
        $token = new Token('comment', 'some string', 'testlang', 'testalias');
        $node = $token->toNode();

        $this->doc->appendChild($node);

        $this->assertInstanceOf('\DOMElement', $node);

        $html = trim($node->ownerDocument->saveHTML());

        $this->assertEquals("<span class=\"token comment testalias\" spellcheck=\"true\">some string</span>", $html);
    }

    public function testDomTextToken()
    {
        $this->markTestSkipped();
        $text = $this->doc->createTextNode('some string');
        $token = new Token('type', $text, 'testlang');
        $node = $token->toNode($this->doc, $this->man);

        $this->doc->appendChild($node);
        $this->doc->appendChild($text);
        
        $html = trim($node->ownerDocument->saveHTML());
        $this->assertEquals("<span class=\"token type\"></span>some string", $html);

    }

    public function testArrayToken()
    {
        $this->markTestSkipped();
        $string = 'some string';
        $token = new Token('type', 'some other string', 'testlang');
        $text = $this->doc->createTextNode('break');

        $arr = new Token('type2', [$string, $token, false, $text], 'testlang');

        $node = $arr->toNode($this->doc, $this->man);

        $this->doc->appendChild($node);

        $html = trim($node->ownerDocument->saveHTML());

        $this->assertEquals("<span class=\"token type2\">some string<span class=\"token type\">some other string</span>break</span>", $html);
    }
    
}
