<?php namespace Petrenko\TestDataCleaner\Entities;

// TODO: PHP Doc
use CUser;
use Bitrix\Main\UserTable;

class TestUser extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = UserTable::getList(array(
            'filter' => [
                'LOGIC' => 'OR',
                ['NAME' => $this->testDataFilter->getFilter()],
                ['LAST_NAME' => $this->testDataFilter->getFilter()],
                ['SECOND_NAME' => $this->testDataFilter->getFilter()],
                ['LOGIN' => $this->testDataFilter->getFilter()],
            ],
            'select' => ['ID', 'NAME'],
        ))->fetchAll();

        return array_map(function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        foreach ($this->elementsId as $elementId)
        {
            CUser::Delete($elementId);
        }
    }
}