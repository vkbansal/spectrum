<?php
namespace VKBansal;

class PlugTest extends \PHPUnit_Framework_TestCase{

    protected $plugin;
    protected $plug;

    public function setUp()
    {
        $this->plugin = $this->getMockForAbstractClass('VKBansal\Prism\Plugin\AbstractPlugin');
        $this->plugin
            ->method('getName')->will($this->returnValue('test-plugin'));
        $this->plugin
            ->method('add')->will($this->returnValue(true));
        $this->plugin
            ->method('remove')->will($this->returnValue(true));

        $this->plug = $this->getMockForTrait('VKBansal\Prism\Plugin\PluggableTrait', [], 'Prism');
    }

    /**
     * @expectedException           VKBansal\Prism\Plugin\PluginNotFoundException
     */
    public function testRemoveException()
    {
        $this->markTestSkipped();
        $this->plug->addPlugin($this->plugin);
        $this->plug->removePlugin('test-plugin');
        $this->plug->removePlugin('test-plugin');
    }
}
