<?php

class HooksTest extends PHPUnit_Framework_TestCase {

    protected $hooks;

    public function setUp()
    {
        $this->hooks = $this->getMockForTrait('VKBansal\Prism\Hook\HookableTrait');
    }

    public function testHooks()
    {
        $counter = 0;
        $hooks = $this->hooks;

        $hooks->addHook('test','1', function(&$env){
            ++$env['counter'];
        });

        $hooks->addHook('test', "remove", function(&$env){
            $env['counter']++;
        });

        $env = ['counter' => &$counter];

        $hooks->runHook('test', $env);
        $hooks->runHook('test2');
        $this->assertEquals(2, $counter);
    }

    public function testRemoveHooks()
    {
        $counter = 0;
        $hooks = $this->hooks;

        $hooks->addHook('test', 'removeMe', function(&$env){
            ++$env['counter'];
        });

        $hooks->removeHook('test', 'removeMe');

        $env = ['counter' => &$counter];

        $hooks->runHook('test', $env);

        $this->assertEquals(0, $counter);
    }
}
