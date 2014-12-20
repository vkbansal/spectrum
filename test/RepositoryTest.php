<?php
use VKBansal\Prism\Languages\Repository;
use VKBansal\Prism\Hooks\Hooks;

class RepositoryTest extends PHPUnit_Framework_TestCase {

    protected $repo;
    
    public function setUp()
    {
        $this->repo = new Repository(new Hooks());
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

        $this->assertTrue(isset($lang['comment']));

        $lang = $this->repo->getDefinition('markup.tag.inside.tag.inside');
        $this->assertTrue(isset($lang['punctuation']));
    }

    public function testReferDefinitionRoot()
    {
        $lang =& $this->repo->referDefinition();

        $lang['dummytag'] = 'dummyvalue';

        $test = $this->repo->getDefinition();

        $this->assertTrue(isset($test['dummytag']));

        unset($lang);
    }

    public function testReferDefinition()
    {
        $lang =& $this->repo->referDefinition('markup');

        $lang['dummytag'] = 'dummyvalue';

        $test = $this->repo->getDefinition('markup');

        $this->assertTrue(isset($test['dummytag']));
        $this->assertTrue(isset($test['dummytag']));

        unset($lang);
    }
    
    public function testReferDefinitionDeep()
    {
        $lang =& $this->repo->referDefinition('markup.tag.inside.tag.inside');
        
        $lang['dummytag'] = 'dummyvalue';        
        
        $test = $this->repo->getDefinition('markup.tag.inside.tag.inside');
        
        $this->assertTrue(isset($test['punctuation']));

        unset($lang);
    }
}
