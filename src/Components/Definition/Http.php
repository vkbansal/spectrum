<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * HTTP definition
 * @package VKBansal\Prism\Definition\Http
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class Http extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'http';
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'request-line' => [
                "pattern" => "/^(POST|GET|PUT|DELETE|OPTIONS|PATCH|TRACE|CONNECT)\b\shttps?:\/\/\S+\sHTTP\/[0-9.]+/",
                "inside" => [
                    // HTTP Verb
                    "property" => "/^\b(POST|GET|PUT|DELETE|OPTIONS|PATCH|TRACE|CONNECT)\b/",
                    // Path or query argument
                    'attr-name' => "/:\w+/"
                ]
            ],
            'response-status' => [
                "pattern" => "/^HTTP\/1.[01] [0-9]+.*/",
                "inside" => [
                    // Status, e.g. 200 OK
                    "property" => "/[0-9]+[A-Z\s-]+$/i"
                ]
            ],
            // HTTP header name
            "keyword" => "/^[\w-]+:(?=.+)/m"
        ];
    }

    public function setup()
    {
        // Create a mapping of Content-Type headers to language definitions
        $httpLanguages = [
            'application/json' => $this->getDefinition('javascript'),
            'application/xml' => $this->getDefinition('markup'),
            'text/xml' => $this->getDefinition('markup'),
            'text/html' => $this->getDefinition('markup')
        ];

        // Insert each content type parser that has its associated language
        // currently loaded.
        foreach ($httpLanguages as $contentType => $language) {
            if (!is_null($language)) {
                $options = [];
                $options[$contentType] = [
                    "pattern" => "/(content-type:\s*" . preg_replace("/\//", "\/", $contentType) . "[\w\W]*?)\\n\\n[\w\W]*/i",
                    "lookbehind" => true,
                    "inside" => [
                        "rest" => $language
                    ]
                ];
                $this->insertBefore('http', $options, 'keyword');
            }
        }
    }
}
