<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\AssetManager;

/**
 * Abstract class for language definitions
 * @package VKBansal\Prism\Definition\AbstractLanguage
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
abstract class AbstractLanguage
{
    /**
     * Prism Instance
     * @var \VKBansal\Prism\AssetManager
     */
    protected $manager;

    /**
     * constructor
     * @param \VKBansal\Prism\AssetManager $manager
     */
    public function __construct(AssetManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Extend language definition
     * @param  string $id    ID of the lang to be extended from
     * @param  array  $redef Additional definitions
     * @return array
     */
    public function extend($id, $redef)
    {
        $this->manager->loadDefinition($id);
        $lang = $this->manager->getDefinition($id);

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
        $root =& $this->manager->referDefinition($inside);

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

        $def =& $this->manager->referDefinition();

        array_walk_recursive($def, function (&$value, $key) use ($root, $rootKey, $ret) {
            if ($value === $root && $key !== $rootKey) {
                $value = $ret;
            }
        });

        return $root = $ret;
    }

    /**
     * Language definition
     * @return array
     */
    abstract public function definition();

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
