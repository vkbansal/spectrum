<?php
namespace VKBansal\Prism\Languages;

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
     * @var VKBansal\Prism\Languages\Repository
     */
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Extend language definition
     * @param  string $id    ID of the lang to be extended from
     * @param  array  $redef Additional definitions
     * @return array
     */
    public function extend($id, $redef)
    {
        $this->repository->loadDefinition($id);
        $lang = $this->repository->getDefinition($id);

        foreach ($redef  as $key => $value) {
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
    public function insertBefore($inside, $insert, $before = null)
    {
        $root =& $this->repository->referDefinition($inside);

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

        array_walk_recursive($this->repository->referDefinition(), function (&$value, $key) use ($root, $rootKey, $ret) {
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
     * @return mixed
     */
    public function setup()
    {
        return true;
    }
}
