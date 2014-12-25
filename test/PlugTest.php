<?php

class PlugTest extends PHPUnit_Framework_TestCase{

    protected $plugin;
    protected $plug;

    public function setUp()
    {
        $this->plugin = $this->getMockBuilder('VKBansal\Prism\Plugin\PluginInterface')
                        ->getMock();
        $this->plug = $this->getMockForTrait('VKBansal\Prism\Plugin\PluggableTrait');
        $this->plug->method('removeHook')
            ->will($this->returnValue(true));
    }

    /**
     * @expectedException           VKBansal\Prism\Plugin\PluginException
     * @expectedExceptionMessage    Plugin handle must return a closure
     */
    public function testCallableException()
    {
        $this->plugin->method('handle')
            ->will($this->returnValue(['hook', 'name']));

        $this->plug->addPlugin($this->plugin);
    }

    /**
     * @expectedException           VKBansal\Prism\Plugin\PluginException
     * @expectedExceptionMessage    The closure must return the return value from hook
     */
    public function testReturnException()
    {
        $this->plugin->method('handle')
            ->will($this->returnValue(function(){}));

        $this->plug->addPlugin($this->plugin);
    }

    /**
     * @expectedException           VKBansal\Prism\Plugin\PluginException
     * @expectedExceptionMessage    Plugin must have name
     */
    public function testNameException()
    {
        $this->plugin->method('handle')
            ->will($this->returnValue(function(){return ['hook', null];}));

        $this->plug->addPlugin($this->plugin);
    }

    /**
     * @expectedException           VKBansal\Prism\Plugin\PluginNotFoundException
     */
    public function testRemoveException()
    {
        $this->plug->removePlugin('test');
    }

    public function testPlugin()
    {
        $this->plugin->method('handle')
            ->will($this->returnValue(function(){return ['hook', 'name'];}));

        $this->plug->addPlugin($this->plugin);
        $this->plug->removePlugin('name');
    }
}