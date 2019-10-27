<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use CIBlock;
use CIBlockType;
use CIBlockElement;
use Petrenko\TestDataCleaner\TestDataFilter;

/**
 * Тестовое окружение для сущностей модуля iblock.
 */
class IblockTestEnvironment extends TestEnvironment
{
    protected $ibTypeIds = array();
    protected $ibIds = array();
    protected $ibSectionIds = array();
    protected $ibElementIds = array();

    public function create()
    {
        $this->createIbTypes();
        $this->createIbs();
        $this->createIbSections();
        $this->createIbElements();
    }

    public function remove()
    {
        $this->removeIbElements();
        $this->removeIbSections();
        $this->removeIbs();
        $this->removeIbTypes();
    }

    protected function createIbTypes()
    {
        $iblockTypeObj = new CIBlockType();

        $id = 'petrenko_tdc_ibt_1';
        $iblockTypeObj->Add(array(
            'ID' => $id,
            'LANG' => array('ru' => array('NAME' => $id))
        ));
        $this->ibTypeIds[] = $id;
    }

    protected function createIbs()
    {
        $iblockObj = new CIBlock();
        $id = $iblockObj->Add(array(
            'ACTIVE' => 'Y',
            'NAME' => 'petrenko_tdc_ib_1',
            'CODE' => 'petrenko_tdc_ib_1',
            'SITE_ID' => array('s1'),
            'VERSION' => 2,
            'IBLOCK_TYPE_ID' => current($this->ibTypeIds)
        ));
        $this->ibIds[] = $id;
    }

    protected function createIbSections()
    {

    }

    protected function createIbElements()
    {
        $iblockId = current($this->ibIds);
        $iblockElementsFields = array(
            array(
                'IBLOCK_ID' => $iblockId,
                'NAME' => 'petrenko_tdc_ibe_1'
            ),
            array(
                'IBLOCK_ID' => $iblockId,
                'NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD .  'petrenko_tdc_ibe_2'
            ),
            array(
                'IBLOCK_ID' => $iblockId,
                'NAME' => 'petrenko_tdc_ibe_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD
            )
        );

        $iblockElementObj = new CIBlockElement();
        foreach ($iblockElementsFields as $fields)
        {
            $id = $iblockElementObj->Add($fields, false, false);
            $this->ibElementIds[] = $id;
        }
    }

    protected function removeIbTypes()
    {
        foreach ($this->ibTypeIds as $id)
        {
            CIBlockType::Delete($id);
        }
    }

    protected function removeIbs()
    {
        foreach ($this->ibIds as $id)
        {
            CIBlock::Delete($id);
        }
    }

    protected function removeIbSections()
    {

    }

    protected function removeIbElements()
    {
        foreach ($this->ibIds as $id)
        {
            CIBlockElement::Delete($id);
        }
    }
}