<?php

use Bitrix\Iblock\ElementTable;

// TODO: PHP Doc
class CleanableIblockElement extends BaseCleanableEntity
{
    public function findElements(): array
    {
        $elements = ElementTable::getList(array(
            'filter' => array(
                'NAME' => $this->getKeyWordFilter(),
            ),
            'select' => array('ID', 'NAME'),
        ))->fetchAll();

        return array_map(function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        foreach ($this->elementsId as $elementId)
        {
            ElementTable::delete($elementId);
        }
    }
}