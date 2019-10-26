<?php namespace Petrenko\TestDataCleaner\Entities;

// TODO: PHP Docs
abstract class BaseCleanableEntity
{
    protected $searchKeyWord = '';

    protected $elementsId = array();

    /**
     * BaseCleanableEntity constructor.
     *
     * @param string $searchKeyWord
     */
    public function __construct(string $searchKeyWord)
    {
        $this->searchKeyWord = $searchKeyWord;
    }

    public function clean() : void
    {
        $this->elementsId = $this->findElements();
        if ($this->elementsId) {
            $this->removeElements();
        }
    }

    protected function getKeyWordFilter() : string
    {
        return $this->searchKeyWord . '%';
    }

    abstract public function findElements() : array;

    abstract protected function removeElements() : void;
}