<?php
use VKBansal\Prism\Hooks\Hooks;

class HooksTest extends PHPUnit_Framework_TestCase {

    public static $counter = 0;

    public function testHooks(){
        $hooks = new Hooks();

        $hooks->add('test', function(){
            ++self::$counter;
        });

        $hooks->add('test', function(){
            ++self::$counter; 
        });

        $hooks->run('test');
        $hooks->run('test2');

        $this->assertEquals(2, self::$counter);
    }
    
}
