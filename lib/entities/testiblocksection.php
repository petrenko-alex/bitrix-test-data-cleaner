<?php namespace Petrenko\TestDataCleaner\Entities;

use CIBlockSection;
use Bitrix\Iblock\SectionTable;

// TODO: PHP Doc
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
            CIBlockSection::Delete($elementId);
        }
    }
}