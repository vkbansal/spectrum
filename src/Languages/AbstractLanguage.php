<?php
namespace VKBansal\Prism\Languages;

abstract class AbstractLanguage
{
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
     * @param  string  $inside
     * @param  string  $before
     * @param  array   $insert
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

    abstract public function definition();

    public function setup()
    {
        return true;
    }
}
