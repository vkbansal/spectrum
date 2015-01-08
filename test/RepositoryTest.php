<?php

class RepositoryTest extends PHPUnit_Framework_TestCase {

    protected $repo;

    public function setUp()
    {
        $this->markTestSkipped();
        $this->repo = new \VKBansal\Prism\Prism();
        $this->repo->loadDefinition('markup');
    }

    public function testLoadDefinition()
    {
        $this->markTestSkipped();
        $lang = $this->repo->getDefinition();

        $this->assertTrue(isset($lang['markup']));

        $this->repo->loadDefinition('xml');
        $this->assertFalse(isset($lang['xml']));
    }

    public function testGetDefinitionByValue()
    {
        $this->markTestSkipped();
        $lang = $this->repo->getDefinition('markup');
        $this->assertArrayHasKey('comment', $lang);

        $lang = $this->repo->getDefinition('markup.tag.inside.tag.inside');
        $this->assertArrayHasKey('punctuation', $lang);
    }

    public function testgetDefinitionByReference()
    {
        $this->markTestSkipped();
        $reference =& $this->repo->getDefinition();
        $reference['dummytag'] = 'dummyvalue';
        $test = $this->repo->getDefinition();

        $this->assertArrayHasKey('dummytag', $test);
        unset($reference);
    }

    public function testReferDefinitionDeep()
    {
        $this->markTestSkipped();
        $lang =& $this->repo->getDefinition('markup.tag.inside.tag.inside');

        $lang['dummytag'] = 'dummyvalue';

        $test = $this->repo->getDefinition('markup.tag.inside.tag.inside');

        $this->assertArrayHasKey('dummytag', $test);

        unset($lang);
    }

    public function testloadAll()
    {
        $this->markTestSkipped();
        $this->repo->loadAllDefinitions();
    }

    public function testloadDefault()
    {
        $this->markTestSkipped();
        $this->repo->loadDefaultDefinitions();
    }
}
