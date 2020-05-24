<?php namespace Petrenko\TestDataCleaner\Entities;

use CIBlock;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Localization\Loc;

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
            CIBlock::Delete($elementId);
        }
    }

    public function getPublicName(): string
    {
        return Loc::getMessage('PETRENKO.TEST_DATA_CLEANER.ENTITIES.IBLOCK.NAME');
    }
}