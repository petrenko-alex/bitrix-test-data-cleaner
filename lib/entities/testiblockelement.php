<?php namespace Petrenko\TestDataCleaner\Entities;

use CIBlockElement;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Localization\Loc;

// TODO: PHP Doc
class TestIblockElement extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = ElementTable::getList(array(
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
            CIBlockElement::Delete($elementId);
        }
    }

    public function getPublicName(): string
    {
        return Loc::getMessage('PETRENKO.TEST_DATA_CLEANER.ENTITIES.IBLOCK_ELEMENT.NAME');
    }
}