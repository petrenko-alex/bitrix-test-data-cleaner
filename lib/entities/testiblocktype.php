<?php namespace Petrenko\TestDataCleaner\Entities;

use Bitrix\Iblock\TypeTable;

// TODO: PHP Doc
class TestIblockType extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = TypeTable::getList(array(
            'filter' => array(
                'LANG_MESSAGE.NAME' => $this->testDataFilter->getFilter(),
            ),
            'select' => array('ID', 'LANG_MESSAGE.NAME'),
        ))->fetchAll();

        return array_map(function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        foreach ($this->elementsId as $elementId)
        {
            TypeTable::Delete($elementId);
        }
    }
}