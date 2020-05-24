<?php namespace Petrenko\TestDataCleaner\Entities;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable;

Loader::includeModule('highloadblock');

// TODO: PHP Doc
class TestHlb extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = HighloadBlockTable::getList(array(
            'filter' => array(
                'LANG.NAME' => $this->testDataFilter->getFilter(),
            ),
            'select' => array('ID', 'NAME'),
        ))->fetchAll();

        return array_map(function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        foreach ($this->elementsId as $elementId)
        {
            HighloadBlockTable::delete($elementId);
        }
    }

    public function getPublicName(): string
    {
        return Loc::getMessage('PETRENKO.TEST_DATA_CLEANER.ENTITIES.HLB.NAME');
    }
}