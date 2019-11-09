<?php namespace Petrenko\TestDataCleaner\Entities;

use Bitrix\Iblock\IblockTable;

// TODO: PHP Doc
class TestIblock extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = IblockTable::getList(array(
            'filter' => array(
                'NAME' => $this->testDataFilter->getFilter(),
            ),
            'select' => array('ID', 'NAME'),
        ))->fetchAll();

        return array_map(function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        foreach ($this->elementsId as $elementId)
        {
            IblockTable::delete($elementId);
        }
    }
}