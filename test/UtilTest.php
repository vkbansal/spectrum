<?php
use VKBansal\Spectrum\Util;

class UtilTest extends PHPUnit_Framework_TestCase {

    public function testIsAssoc()
    {
        $this->assertFalse(Util::isAssoc([1, 2]));
        $this->assertTrue(Util::isAssoc(['1' => '2', 'test' => '123']));
    }

    public function testHtmlEncode()
    {
        $encoded = file_get_contents(__DIR__."/resources/htmlEncoded.html");
        $decoded = file_get_contents(__DIR__."/resources/htmlDecoded.html");

        $this->assertEquals($encoded, Util::encodeCodeBlocks($decoded));
    }

    public function testHtmlDecode()
    {
        $encoded = file_get_contents(__DIR__."/resources/htmlEncoded.html");
        $decoded = file_get_contents(__DIR__."/resources/htmlDecoded.html");

        $this->assertEquals($decoded, Util::decodeCodeBlocks($encoded));
    }

    public function testGetInnerHtml()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("div", "Test content");

        $this->assertEquals("Test content", Util::getInnerHtml($elem));
    }

    public function testSetInnerHtml()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("div");

        $nodes = [
            $doc->createTextNode("Test"),
            $doc->createTextNode(" content")
        ];

        Util::setInnerHTML($elem, $nodes);

        $this->assertEquals("Test content", Util::getInnerHtml($elem));
    }

    public function testAddClass()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("div");

        Util::addClass($elem, "test");

        $this->assertEquals("test", $elem->getAttribute('class'));
    }

    public function testRemoveClassString()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("div");

        Util::addClass($elem, "myclass language-test dummy test");
        Util::removeClass($elem, "myclass dummy");

        $this->assertEquals("language-test test", $elem->getAttribute('class'));

    }

    public function testRemoveClassRegex()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("div");

        Util::addClass($elem, "myclass language-test dummy test");
        Util::removeClass($elem, "/\blang(?:uage)?-(?!\*)(\w+)\b/i", true);

        $this->assertEquals("myclass dummy test", $elem->getAttribute('class'));
    }

    public function testDetectLanguage()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("div");

        Util::addClass($elem, "myclass language-test dummy test");
        $this->assertEquals("test", Util::detectLanguage($elem));

        Util::removeClass($elem, "language-test");
        $this->assertEquals("", Util::detectLanguage($elem));
    }

    public function testIsPre()
    {
        $doc = new DOMDocument();
        $elem = $doc->createElement("PRE");

        $this->assertTrue(Util::isPre($elem));
    }

    public function testHasValue()
    {
        $dummy = [
            'key' => 'value'
        ];
        $default = microtime(true);

        $this->assertEquals($dummy['key'], Util::hasValue($dummy, 'key'));
        $this->assertEquals($default, Util::hasValue($dummy, 'otherkey', $default));
    }

}
