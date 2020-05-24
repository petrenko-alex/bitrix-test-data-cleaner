<?php namespace Petrenko\TestDataCleaner\Entities;

use CIBlockProperty;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Localization\Loc;

// TODO: PHP Doc
class TestIblockProperty extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = PropertyTable::getList(array(
            'filter' => array(
                'NAME' => $this->testDataFilter->getFilter(),
            ),
            'select' => array('ID', 'NAME'),
        ))->fetchAll();

        return array_map(static function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        foreach ($this->elementsId as $elementId)
        {
            CIBlockProperty::Delete($elementId);
        }
    }

    public function getPublicName(): string
    {
        return Loc::getMessage('PETRENKO.TEST_DATA_CLEANER.ENTITIES.IBLOCK_PROPERTY.NAME');
    }
}