<?php namespace Petrenko\TestDataCleaner;

use Petrenko\TestDataCleaner\Entities\BaseTestEntity;

class TestDataCleaner
{
    // TODO: think about making some methods protected in order to extend class
    private $entities = [];
    private $testDataFilter = null;

    public function __construct(array $entities)
    {
        $this->entities = $entities;
        $this->testDataFilter = new TestDataFilter();

        $this->prepareEntities();
    }

    private function prepareEntities(): void
    {
        $this->entities = array_filter($this->entities);
        $this->entities = array_unique($this->entities);
        $this->entities = array_intersect($this->entities, EntitiesFactory::getOrderedEntities());

        $this->sortEntities();
    }

    private function sortEntities(): void
    {
        $correctOrder = EntitiesFactory::getOrderedEntities();

        uasort(
            $this->entities,
            static function ($val1, $val2) use ($correctOrder) {
                return array_search($val1, $correctOrder) <=> array_search($val2, $correctOrder);
            }
        );
    }

    public function clean(): void
    {
        // TODO: go foreach and clean
    }

    public function get(): array
    {
        $testElements = [];

        foreach ($this->entities as $entity)
        {
            $entityData = [
                'TOTAL_COUNT' => 0
            ];

            $entityClass = EntitiesFactory::getClassByName($entity);
            if (!$entityClass)
                continue;

            $testEntity = new $entityClass($this->testDataFilter);
            if (!$testEntity)
                continue;

            /** @var BaseTestEntity $testEntity */
            $entityData['ID'] = $testEntity->findElements();
            $entityData['COUNT'] = count($entityData['ID']);
            $entityData['PUBLIC_NAME'] = $testEntity->getPublicName();

            $testElements['ENTITIES'][$entity] = $entityData;
            $testElements['TOTAL_COUNT'] += $entityData['COUNT'];
        }

        return $testElements;
    }
}