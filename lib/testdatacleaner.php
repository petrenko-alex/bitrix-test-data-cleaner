<?php namespace Petrenko\TestDataCleaner;

class TestDataCleaner
{
    // TODO: think about making some methods protected in order to extend class
    private $entities = [];

    public function __construct(array $entities)
    {
        $this->entities = $entities;

        $this->prepareEntities();
        // TODO: get classes
    }

    private function prepareEntities()
    {
        $this->entities = array_filter($this->entities);
        $this->entities = array_unique($this->entities);
        $this->entities = array_intersect($this->entities, EntitiesFactory::getOrderedEntities());

        $this->sortEntities();
    }

    private function sortEntities()
    {
        $correctOrder = EntitiesFactory::getOrderedEntities();

        uasort($this->entities, function($val1, $val2) use ($correctOrder) {
            return array_search($val1, $correctOrder) <=> array_search($val2, $correctOrder);
        });
    }

    public function clean()
    {
        // TODO: go foreach and clean
    }

    public function show(array $entities)
    {
        // TODO: go foreach and collect
    }
}