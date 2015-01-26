<?php
use VKBansal\Prism\Token\Token;
use VKBansal\Prism\AssetManager;

class TokenTest extends PHPUnit_Framework_TestCase
{
    protected $doc;
    protected $prism;

    public function setUp()
    {
        $this->doc = new \DOMDocument();
        $this->prism = $this->getMockBuilder('VKBansal\Prism\Prism')->getMock();
        $this->prism->method('getDocument')->will($this->returnValue($this->doc));
    }

    public function testStringToken()
    {
        $token = new Token('comment', 'some string', 'testlang', 'testalias');
        $node = $token->toNode($this->prism);

        $this->doc->appendChild($node);

        $this->assertInstanceOf('\DOMElement', $node);

        $html = trim($node->ownerDocument->saveHTML());

        $this->assertEquals("<span class=\"token comment testalias\" spellcheck=\"true\">some string</span>", $html);
    }

    public function testDomTextToken()
    {
        $text = $this->doc->createTextNode('some string');
        $token = new Token('type', [$text], 'testlang');
        $node = $token->toNode($this->prism);

        $this->doc->appendChild($node);
        $this->doc->appendChild($text);

        $html = trim($node->ownerDocument->saveHTML());
        $this->assertEquals("<span class=\"token type\"></span>some string", $html);

    }

    public function testArrayToken()
    {
        $string = 'some string';
        $token = new Token('type', 'some other string', 'testlang');
        $text = $this->doc->createTextNode('break');

        $arr = new Token('type2', [$string, $token, false, $text], 'testlang');

        $node = $arr->toNode($this->prism);

        $this->doc->appendChild($node);

        $html = trim($node->ownerDocument->saveHTML());

        $this->assertEquals("<span class=\"token type2\">some string<span class=\"token type\">some other string</span>break</span>", $html);
    }

}
