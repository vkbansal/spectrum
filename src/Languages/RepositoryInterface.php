<?php
namespace VKBansal\Prism\Languages;

interface RepositoryInterface
{
    public function loadDefinition($language);

    public function &referDefinition($language = null);

    public function getDefinition($language = null);

    public function hasDefinition($language);
}
