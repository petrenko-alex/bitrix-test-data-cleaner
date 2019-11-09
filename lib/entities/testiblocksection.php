<?php namespace Petrenko\TestDataCleaner\Entities;

// TODO: PHP Doc
use Bitrix\Iblock\SectionTable;

class TestIblockSection extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = SectionTable::getList(array(
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
            SectionTable::Delete($elementId);
        }
    }
}