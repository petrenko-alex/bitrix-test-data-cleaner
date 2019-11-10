<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;
use Petrenko\TestDataCleaner\TestDataFilter;
use Bitrix\Highloadblock\HighloadBlockLangTable;

Loader::includeModule('highloadblock');

/**
 * Тестовое окружение для сущности highload-блока.
 */
class HlbTestEnvironment
{
    private static $prefix = 'petrenko_tdc_';

    public static function create(): void
    {
        $hlbFields = [
            [
                'NAME' => 'TestEntity1',
                'TABLE_NAME' => static::$prefix . 'hlb_1',
                'LANG_NAME' => static::$prefix . 'hlb_1',
            ],
            [
                'NAME' => 'TestEntity2',
                'TABLE_NAME' => static::$prefix . 'hlb_2',
                'LANG_NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'hlb_2'
            ],
            [
                'NAME' => 'TestEntity3',
                'TABLE_NAME' => static::$prefix . 'hlb_3',
                'LANG_NAME' => static::$prefix . 'hlb_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
            ],
            [
                'NAME' => 'TestEntity4',
                'TABLE_NAME' => static::$prefix . 'hlb_4',
                'LANG_NAME' => static::$prefix . 'hlb_4 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
            ],
        ];

        foreach ($hlbFields as $fields)
        {
            $res = HighloadBlockTable::add($fields);
            if ($res->isSuccess())
            {
                $res = HighloadBlockLangTable::add([
                    'LID' => 'ru',
                    'ID' => $res->getId(),
                    'NAME' => $fields['LANG_NAME']
                ]);
            }
        }
    }

    public static function remove(): void
    {
        $hlbs = HighloadBlockTable::getList(array(
            'filter' => array('LANG.NAME' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($hlbs as $hlb)
        {
            HighloadBlockTable::delete($hlb['ID']);
        }
    }
}