<?php
use VKBansal\Prism\Hook\HookableTrait;

class Hooks {
    use HookableTrait;
}

class HooksTest extends PHPUnit_Framework_TestCase {

    public function testHooks()
    {
        $counter = 0;
        $hooks = new Hooks();

        $hooks->addHook('test', function(&$env){
            ++$env['counter'];
        });

        $hooks->addHook('test', function(&$env){
            $env['counter']++; 
        });

        $env = ['counter' => &$counter];

        $hooks->runHook('test', $env);
        $hooks->runHook('test2');

        $this->assertEquals(2, $counter);
    }
}
