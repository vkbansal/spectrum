<?php

use VKBansal\Prism\Prism;

class RepositoryTest extends PHPUnit_Framework_TestCase {

    protected $repo;
    
    public function setUp()
    {
        $this->repo = new Prism();
        $this->repo->loadDefinition('markup');
    }

    public function testLoadDefinition()
    {
        $lang = $this->repo->getDefinition();

        $this->assertTrue(isset($lang['markup']));
        
        $this->repo->loadDefinition('xml');
        $this->assertFalse(isset($lang['xml']));
    }

    public function testGetDefinition()
    {
        $lang = $this->repo->getDefinition('markup');
        $this->assertArrayHasKey('comment', $lang);

        $lang = $this->repo->getDefinition('markup.tag.inside.tag.inside');
        $this->assertArrayHasKey('punctuation', $lang);
    }

    public function testReferDefinitionRoot()
    {
        $lang =& $this->repo->referDefinition();

        $lang['dummytag'] = 'dummyvalue';

        $test = $this->repo->getDefinition();

        $this->assertArrayHasKey('dummytag', $test);

        unset($lang);
    }

    public function testReferDefinition()
    {
        $lang =& $this->repo->referDefinition('markup');

        $lang['dummytag'] = 'dummyvalue';

        $test = $this->repo->getDefinition('markup');

        $this->assertArrayHasKey('dummytag', $test);
        $this->assertArrayHasKey('dummytag', $test);

        unset($lang);
    }
    
    public function testReferDefinitionDeep()
    {
        $lang =& $this->repo->referDefinition('markup.tag.inside.tag.inside');
        
        $lang['dummytag'] = 'dummyvalue';        
        
        $test = $this->repo->getDefinition('markup.tag.inside.tag.inside');
        
        $this->assertArrayHasKey('punctuation', $test);

        unset($lang);
    }

    public function testloadAll()
    {
        $this->repo->loadAllDefinitions();
    }

    public function testloadDefault()
    {
        $this->repo->loadDefaultDefinitions();
    }
}
