<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use CIBlock;
use CIBlockType;
use CIBlockElement;

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
        $iblockElementObj = new CIBlockElement();
        $id = $iblockElementObj->Add(
            array(
              'IBLOCK_ID' => current($this->ibIds),
              'NAME' => 'petrenko_tdc_ibe_1'
            ),
            false,
            false
        );
        $this->ibElementIds[] = $id;
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