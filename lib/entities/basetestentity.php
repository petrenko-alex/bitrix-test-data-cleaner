<?php namespace Petrenko\TestDataCleaner\Entities;

use Petrenko\TestDataCleaner\TestDataFilter;

// TODO: PHP Docs
abstract class BaseTestEntity
{
    protected $testDataFilter = '';
    protected $elementsId = array();

    /**
     * BaseCleanableEntity constructor.
     *
     * @param TestDataFilter $testDataFilter
     */
    public function __construct(TestDataFilter $testDataFilter)
    {
        $this->testDataFilter = $testDataFilter;
    }

    public function clean(): void
    {
        $this->elementsId = $this->findElements();
        if ($this->elementsId) {
            $this->removeElements();
        }
    }

    abstract public function findElements(): array;

    abstract protected function removeElements(): void;
}