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

    public function testHooksNamed()
    {
        $counter = 0;
        $hooks = new Hooks();

        $hooks->addHook('test', function(&$env){
            ++$env['counter'];
        }, 'test1');

        $hooks->addHook('test', function(&$env){
            $env['counter']++;
        }, 'test2');

        $env = ['counter' => &$counter];

        $hooks->runHook('test', $env);

        $this->assertEquals(2, $counter);
    }

    public function testRemoveHooks()
    {
        $counter = 0;
        $hooks = new Hooks();

        $hooks->addHook('test', function(&$env){
            ++$env['counter'];
        });

        $hooks->removeHook('test');

        $env = ['counter' => &$counter];

        $hooks->runHook('test', $env);

        $this->assertEquals(0, $counter);
    }

    public function testRemoveHooksNamed()
    {
        $counter = 0;
        $hooks = new Hooks();

        $hooks->addHook('test', function(&$env){
            ++$env['counter'];
        }, 'test1');

        $hooks->addHook('test', function(&$env){
            $env['counter']++;
        }, 'test2');

        $hooks->removeHook('test', 'test2');

        $env = ['counter' => &$counter];

        $hooks->runHook('test', $env);

        $this->assertEquals(1, $counter);
    }
}
