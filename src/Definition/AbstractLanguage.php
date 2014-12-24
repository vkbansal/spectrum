<?php
namespace VKBansal\Prism\Definition;

use VKBansal\Prism\Prism;

/**
 * Abstract class for language definitions
 * @package VKBansal\Prism\Languages\AbstractLanguage
 * @version 0.1.0
 * @author Vivek Kumar Bansal <contact@vkbansal.me>
 * @license MIT
 */
abstract class AbstractLanguage
{
    /**
     * Repository
     * @var RepositoryInterface
     */
    protected $prism;

    /**
     * constructor
     * @param \VKBansal\Prism\Prism $prism
     */
    public function __construct(Prism $prism)
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
        $this->prism->loadDefinition($id);
        $lang = $this->prism->getDefinition($id);

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
     * @return void
     */
    public function insertBefore($inside, array $insert, $before = null)
    {
        $root =& $this->prism->referDefinition($inside);

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

        $def =& $this->prism->referDefinition();

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
