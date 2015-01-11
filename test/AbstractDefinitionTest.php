<?php

class AbstractDefinitionTest extends PHPUnit_Framework_TestCase {

    protected $def;
    protected $prism;

    public function setUp()
    {
        $this->def = $this->getMockBuilder('VKBansal\Prism\Language\AbstractDefinition')
            ->setMethods(['getDefinition', 'definition', 'getName', 'loadDefinition'])
            ->getMock();
        $lang = [
            'token1' => 'default1',
            'token2' => 'default2'
        ];
        $this->def->method('getDefinition')->will($this->returnValue($lang));
    }

    public function testExtend()
    {
        $extend = $this->def->extend('mylang', [
            'token3' => 'default3'
        ]);

        $this->assertEquals($extend, [
            'token1' => 'default1',
            'token2' => 'default2',
            'token3' => 'default3'
        ]);
    }

    public function testInsertBefore()
    {
        $insert = $this->def->insertBefore('mylang',[
            'token3' => 'default3'
        ],'token2');

         $this->assertEquals($insert, [
            'token1' => 'default1',
            'token3' => 'default3',
            'token2' => 'default2'
        ]);

         $insertNull = $this->def->insertBefore('mylang',[
            'token3' => 'default3'
        ]);

         $this->assertEquals($insertNull, [
            'token1' => 'default1',
            'token2' => 'default2',
            'token3' => 'default3'
        ]);
    }

}
