<?php
use VKBansal\Prism\Hooks\Hooks;

class HooksTest extends PHPUnit_Framework_TestCase {

    public function testHooks()
    {
        $counter = 0;
        $hooks = new Hooks();

        $hooks->add('test', function(&$env){
            ++$env['counter'];
        });

        $hooks->add('test', function(&$env){
            $env['counter']++; 
        });

        $env = ['counter' => &$counter];

        $hooks->run('test', $env);
        $hooks->run('test2');

        $this->assertEquals(2, $counter);
    }
}
