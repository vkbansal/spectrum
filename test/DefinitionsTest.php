<?php
use VKBansal\Prism\Languages\Repository;
use VKBansal\Prism\Hooks\Hooks;

class DefinitionsTest extends PHPUnit_Framework_TestCase {

    protected $repo;
    
    public function setUp()
    {
        $this->repo = new Repository(new Hooks());
    }

    public function testDefinitionsForErrors()
    {
        $this->repo->loadAllDefinitions('markup');
    }
    
}
