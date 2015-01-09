<?php
namespace VKBansal\Prism\Components\Definition;

use VKBansal\Prism\Language\AbstractDefinition;

/**
 * ASP.NET definition
 * @package VKBansal\Prism\Definition\AspNet
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
class AspNet extends AbstractDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'aspnet';
    }

    /**
     * {@inheritdoc}
     */
    public function requires()
    {
        return ['markup', 'csharp', 'css', 'javascript'];
    }

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return $this->extend('markup', [
            'page-directive tag' => [
                "pattern" => "/<%\s*@.*%>/i",
                "inside" => [
                    'page-directive tag' => "/<%\s*@\s*(?:Assembly|Control|Implements|Import|Master|MasterType|OutputCache|Page|PreviousPageType|Reference|Register)?|%>/i",
                    "rest" => $this->getDefinition('markup.tag.inside')
                ]
            ],
            'directive tag' => [
                "pattern" => "/<%.*%>/i",
                "inside" => [
                    'directive tag' => "/<%\s*?[$=%#:]{0,2}|%>/i",
                    "rest" => $this->getDefinition('csharp', [])
                ]
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setup()
    {
        // match directives of attribute value foo="<% Bar %>"
        $this->insertBefore('aspnet.tag.inside.attr-value.inside', [
            'directive tag' => $this->getDefinition('aspnet')['directive tag']
        ], 'punctuation');

        $this->insertBefore('aspnet', [
            'asp comment'=> "/<%--[\w\W]*?--%>/"
        ], 'comment');

        // script runat="server" contains csharp, not javascript
        $before = $this->hasDefinition('javascript') ? 'script' : 'tag';
        $this->insertBefore('aspnet', [
            'asp script' => [
                "pattern" => "/<script(?=.*runat=['\"]?server['\"]?)[\w\W]*?>[\w\W]*?<\/script>/i",
                "inside" => [
                    "tag" => [
                        "pattern" => "/<\/?script\s*(?:\s+[\w:-]+(?:=(?:(\"|')(\\\\?[\w\W])*?\g{1}|\w+))?\s*)*\/?>/i",
                        "inside" => $this->getDefinition("aspnet.tag.inside")
                    ],
                    "rest" => $this->getDefinition('csharp', [])
                ]
            ]
        ], $before);

        // Hacks to fix eager tag matching finishing too early: <script src="<% Foo.Bar %>"> => <script src="<% Foo.Bar %>
        if ($this->hasDefinition('aspnet.style')) {
            $style =& $this->getDefinition('aspnet.style');
            $style["inside"] = [];
            $style["inside"]["tag"] = [];
            $style["inside"]["tag"]["pattern"] = "/<\/?style\s*(?:\s+[\w:-]+(?:=(?:(\"|')(\\\\?[\w\W])*?\g{1}|\w+))?\s*)*\/?>/i";
            $style["inside"]["tag"]["inside"] = $this->getDefinition('aspnet.tag.inside');
        }
        if ($this->hasDefinition('aspnet.script')) {
            $script =& $this->getDefinition('aspnet.script');
            $script["inside"] = [];
            $script["inside"]["tag"] = [];
            $script["inside"]["tag"]["pattern"] = $this->getDefinition('aspnet')['asp script']['inside']['tag']['pattern'];
            $script["inside"]["tag"]["inside"] = $this->getDefinition('aspnet.tag.inside');
        }
    }
}
