<?php
namespace VKBansal\Prism\Language;

use VKBansal\Prism\Language\DefinitionInterface;
use VKBansal\Prism\Hook\HookInterface;
use VKBansal\Prism\Prism;

/**
 * Abstract class for language definitions
 * @package VKBansal\Prism\Language\AbstractDefinition
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
abstract class AbstractDefinition implements DefinitionInterface, HookInterface
{
    /**
     * Prism Instance
     * @var \VKBansal\Prism\Prism
     */
    protected $prism;

    /**
     * Set Manager
     * @param \VKBansal\Prism\Prism $prism
     */
    public function injectPrism(Prism $prism)
    {
        $this->prism = $prism;
    }

    /**
     * Extend language definition
     * @param  string $id    ID of the lang to be extended from
     * @param  array  $redef Additional definitions
     * @return array
     */
    public function extend($id, $redef)
    {
        $this->loadDefinition($id);
        $lang = $this->getDefinition($id);

        foreach ($redef as $key => $value) {
            $lang[$key] = $value;
        }

        return $lang;
    }

    /**
     * Insert a definition before another
     * @param  string      $inside Key to be used as root
     * @param  array       $insert Definition to be inserted
     * @param  string|null $before Key before which definition should be inserted.
     *                             If not provided, it will be appended.
     * @return array
     */
    public function insertBefore($inside, array $insert, $before = null)
    {
        $root =& $this->getDefinition($inside);

        if (is_null($before)) {
            foreach ($insert as $key => $value) {
                $root[$key] = $value;
            }
            return $root;
        }
        $ret = [];
        foreach ($root as $key => $value) {
            if ($key == $before) {
                foreach ($insert as $newKey => $newValue) {
                    $ret[$newKey] = $newValue;
                }
            }

            $ret[$key] = $root[$key];
        }

        $temp = explode('.', $inside);
        $rootKey = array_shift($temp);

        $def =& $this->getDefinition();

        array_walk_recursive($def, function (&$value, $key) use ($root, $rootKey, $ret) {
            if ($value === $root && $key !== $rootKey) {
                $value = $ret;
            }
        });

        return $root = $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function loadDefinition($language)
    {
        $this->prism->loadDefinition($language);
    }

    /**
     * {@inheritdoc}
     */
    public function &getDefinition($language = null, $default = null)
    {
        return $this->prism->getDefinition($language, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefinition($language)
    {
        return $this->prism->hasDefinition($language);
    }

    /**
     * {@inheritdoc}
     */
    public function addHook($name, \Closure $callback, $refer = null)
    {
        $this->prism->addHook($name, $callback, $refer);
    }

    /**
     * Language definition
     * @return array
     */
    abstract public function definition();

    /**
     * Get name for language
     * @return string
     */
    abstract public function getName();

    /**
     * Does this language needed to lodaed as default
     * @return boolean
     */
    public function isDefault()
    {
        return false;
    }

    /**
     * Aliases for this language
     * @return boolean|string|string[]
     */
    public function aliases()
    {
        return false;
    }

    /**
     * Extra setup after definition.
     * Override if needed in respective language definitions.
     * @return boolean
     */
    public function setup()
    {
        return true;
    }
}
