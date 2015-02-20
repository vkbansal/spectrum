<?php
namespace VKBansal\Spectrum\Components\Definition;

use VKBansal\Spectrum\Language\AbstractDefinition;

/**
 * Gherkin definition
 * @package VKBansal\Spectrum\Definition\Gherkin
 * @version 0.3.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Gherkin extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    protected static $name = 'gherkin';

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        // remaining:
        //      - Support for outline parameters
        //      - Support for tables
        return [
            'comment' => [
                "pattern" => "/(^|[^\\\\])(\/\*[\\w\\W]*?\*\/|((#)|(\/\/)).*?(\\r?\\n|$))/",
                "lookbehind" => true
            ],
            'string' => "/(\"|')(\\\\?.)*?\g{1}/",
            'atrule' => "/\b(And|Given|When|Then|In order to|As an|I want to|As a)\b/",
            'keyword' => "/\b(Scenario Outline|Scenario|Feature|Background|Story)\b/",
        ];
    }
}
