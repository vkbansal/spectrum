<?php
use VKBansal\Prism\Util;

class UtilTest extends PHPUnit_Framework_TestCase {

    public function testIsAssoc(){
        $this->assertFalse(Util::isAssoc([1, 2]));
        $this->assertTrue(Util::isAssoc(['1' => '2', 'test' => '123']));
    }
    
    public function testHtmlEncode(){
        $encoded = file_get_contents(__DIR__."/resources/htmlEncoded.html");
        $decoded = file_get_contents(__DIR__."/resources/htmlDecoded.html");

        $this->assertEquals($encoded, Util::encodeCodeBlocks($decoded));
    }

    public function testHtmlDecode(){
        $encoded = file_get_contents(__DIR__."/resources/htmlEncoded.html");
        $decoded = file_get_contents(__DIR__."/resources/htmlDecoded.html");

        $this->assertEquals($decoded, Util::decodeCodeBlocks($encoded));
    }

    public function testDFS(){
        $arr = [
            'key1' => 'one',
            'key2' => ['two' , '2', 'too'],
            'key3' => [ 
                'a' => '123456',
                'b' => '987654'
            ]
        ];

        $arr2 = [
            'key1' => 'onetest',
            'key2' => ['twotest' , '2test', 'tootest'],
            'key3' => [ 
                'a' => '123456test',
                'b' => '987654test'
            ]
        ];

        array_walk_recursive($arr, function(&$value, $key){
            if(is_string($value)) {
                $value .="test";
            }
            //var_dump($obj);
        });
        $this->assertEquals($arr2, $arr);
    }
}
