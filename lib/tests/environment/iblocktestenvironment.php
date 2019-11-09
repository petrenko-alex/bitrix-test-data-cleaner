<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use CIBlock;
use CIBlockType;
use CIBlockSection;
use CIBlockElement;
use Bitrix\Iblock\TypeTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Petrenko\TestDataCleaner\TestDataFilter;

/**
 * Тестовое окружение для сущностей модуля iblock.
 */
class IblockTestEnvironment
{
    private static $prefix = 'petrenko_tdc_';
    private static $ibTypeIds = [];
    private static $ibIds = [];
    private static $ibSectionIds = [];
    private static $ibElementIds = [];

    public static function create(): void
    {
        static::createIbTypes();
        static::createIbs();
        static::createIbSections();
        static::createIbElements();
    }

    public static function remove(): void
    {
        static::removeIbElements();
        static::removeIbSections();
        static::removeIbs();
        static::removeIbTypes();
    }

    protected static function createIbTypes(): void
    {
        $commonFields = [
            'SECTIONS' => 'Y',
        ];
        $ibTypeFields = [
            array_merge($commonFields,
                [
                    'ID' => static::$prefix . 'ibt_1',
                    'LANG' => [
                        'ru' => [
                            'NAME' => static::$prefix . 'ibt_1',
                        ],
                    ],
                ]),
            array_merge($commonFields,
                [
                    'ID' => static::$prefix . 'ibt_2',
                    'LANG' => [
                        'ru' => [
                            'NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ibt_2',
                        ],
                    ],
                ]),
            array_merge($commonFields,
                [
                    'ID' => static::$prefix . 'ibt_3',
                    'LANG' => [
                        'ru' => [
                            'NAME' => static::$prefix . 'ibt_3' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                        ],
                    ],
                ]),
            array_merge($commonFields,
                [
                    'ID' => static::$prefix . 'ibt_4',
                    'LANG' => [
                        'ru' => [
                            'NAME' => static::$prefix . 'ibt_4'
                                      . TestDataFilter::DEFAULT_FILTER_KEYWORD
                                      . 'extra',
                        ],
                    ],
                ]),
        ];

        $iblockType = new CIBlockType();
        foreach ($ibTypeFields as $fields)
        {
            $result = $iblockType->Add($fields);
            if ($result)
                static::$ibTypeIds[] = $fields['ID'];
        }
    }

    protected static function createIbs(): void
    {
        $commonFields = [
            'ACTIVE' => 'Y',
            'SITE_ID' => array('s1'),
            'VERSION' => 2,
            'IBLOCK_TYPE_ID' => current(static::$ibTypeIds),
        ];
        $ibFields = [
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ib_1',
                    'CODE' => static::$prefix . 'ib_1',
                ]),
            array_merge($commonFields,
                [
                    'NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ib_2',
                    'CODE' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ib_2',
                ]),
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ib_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                    'CODE' => static::$prefix . 'ib_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                ]),
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ib_4' . TestDataFilter::DEFAULT_FILTER_KEYWORD . ' extra',
                    'CODE' => static::$prefix . 'ib_4' . TestDataFilter::DEFAULT_FILTER_KEYWORD . ' extra',
                ]),
        ];

        $iblock = new CIBlock();
        foreach ($ibFields as $fields)
        {
            $id = $iblock->Add($fields);
            if ($id !== false)
                static::$ibIds[] = $id;
        }
    }

    protected static function createIbSections(): void
    {
        $commonFields = [
            'IBLOCK_ID' => current(static::$ibIds),
            'TIMESTAMP_X' => new DateTime(),
        ];
        $ibSectionFields = [
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ibs_1',
                    'CODE' => static::$prefix . 'ibs_1',
                ]),
            array_merge($commonFields,
                [
                    'NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ibs_2',
                    'CODE' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ibs_2',
                ]),
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ibs_3' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                    'CODE' => static::$prefix . 'ibs_3' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                ]),
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ibs_4' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
                    'CODE' => static::$prefix . 'ibs_4' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
                ]),
        ];

        $iblockSection = new CIBlockSection();
        foreach ($ibSectionFields as $fields)
        {
            $id = $iblockSection->Add($fields, true, false);
            if ($id !== false)
                static::$ibSectionIds[] = $id;
        }
    }

    protected static function createIbElements(): void
    {
        $commonFields = [
            'IBLOCK_ID' => current(static::$ibIds),
        ];
        $iblockElementsFields = [
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ibe_1',
                    'CODE' => static::$prefix . 'ibe_1',
                ]),
            array_merge($commonFields,
                [
                    'NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ibe_2',
                    'CODE' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'ibe_2',
                ]),
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ibe_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                    'CODE' => static::$prefix . 'ibe_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                ]),
            array_merge($commonFields,
                [
                    'NAME' => static::$prefix . 'ibe_4 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
                    'CODE' => static::$prefix . 'ibe_4 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
                ]),
        ];

        $iblockElementObj = new CIBlockElement();
        foreach ($iblockElementsFields as $fields)
        {
            $id = $iblockElementObj->Add($fields, false, false);
            if ($id !== false)
                static::$ibElementIds[] = $id;
        }
    }

    protected static function removeIbTypes(): void
    {
        $ibTypes = TypeTable::getList(array(
            'filter' => array('LANG_MESSAGE.NAME' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($ibTypes as $ibType)
        {
            CIBlockType::Delete($ibType['ID']);
        }
    }

    protected static function removeIbs(): void
    {
        $ibs = IblockTable::getList(array(
            'filter' => array('NAME' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($ibs as $ib)
        {
            CIBlock::Delete($ib['ID']);
        }
    }

    protected static function removeIbSections(): void
    {
        $ibSections = SectionTable::getList(array(
            'filter' => array('NAME' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($ibSections as $ibSection)
        {
            CIBlockSection::Delete($ibSection['ID']);
        }
    }

    protected static function removeIbElements(): void
    {
        $ibElements = ElementTable::getList(array(
            'filter' => array('NAME' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($ibElements as $ibElement)
        {
            CIBlockElement::Delete($ibElement['ID']);
        }
    }
}