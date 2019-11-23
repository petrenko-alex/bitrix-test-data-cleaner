<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use CUser;
use CUserTypeEntity;
use Bitrix\Main\UserTable;
use Bitrix\Main\UserFieldTable;
use Petrenko\TestDataCleaner\TestDataFilter;

/**
 * Тестовое окружение для сущности пользователей.
 */
class UserTestEnvironment
{
    private static $prefix = 'petrenko_tdc_';

    public static function create(): void
    {
        static::createUfs();
        static::createUsers();
    }

    protected static function createUsers(): void
    {
        $commonFields = [
            'PASSWORD' => '123456',
            'CONFIRM_PASSWORD' => '123456',
        ];
        $userFields = [
            array_merge($commonFields, [
                'LOGIN' => static::$prefix . 'u_1',
                'EMAIL' => static::$prefix . 'u_1' . '@test.ru',
                'NAME' => 'username',
                'LAST_NAME' => 'userlastname',
                'SECOND_NAME' => 'usersecondname',
            ]),
            array_merge($commonFields, [
                'LOGIN' => static::$prefix . 'u_2',
                'EMAIL' => static::$prefix . 'u_2' . '@test.ru',
                'NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . 'username',
                'LAST_NAME' => 'userlastname',
                'SECOND_NAME' => 'usersecondname',
            ]),
            array_merge($commonFields, [
                'LOGIN' => static::$prefix . 'u_3',
                'EMAIL' => static::$prefix . 'u_3' . '@test.ru',
                'NAME' => 'username',
                'LAST_NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . ' userlastname',
                'SECOND_NAME' => 'usersecondname',
            ]),
            array_merge($commonFields, [
                'LOGIN' => static::$prefix . 'u_4',
                'EMAIL' => static::$prefix . 'u_4' . '@test.ru',
                'NAME' => 'username',
                'LAST_NAME' => 'userlastname',
                'SECOND_NAME' => TestDataFilter::DEFAULT_FILTER_KEYWORD . 'usersecondname',
            ]),
            array_merge($commonFields, [
                'LOGIN' => TestDataFilter::DEFAULT_FILTER_KEYWORD . ' ' . static::$prefix . 'u_5',
                'EMAIL' => static::$prefix . 'u_5' . '@test.ru',
                'NAME' => 'username',
                'LAST_NAME' => 'userlastname',
                'SECOND_NAME' => 'usersecondname',
            ]),
            array_merge($commonFields, [
                'LOGIN' => static::$prefix . 'u_6' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                'EMAIL' => static::$prefix . 'u_6' . '@test.ru',
                'NAME' => 'username',
                'LAST_NAME' => 'userlastname',
                'SECOND_NAME' => 'usersecondname',
            ]),
            array_merge($commonFields, [
                'LOGIN' => static::$prefix . 'u_7',
                'EMAIL' => static::$prefix . 'u_7' . '@test.ru',
                'NAME' => 'username ' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
                'LAST_NAME' => 'userlastname',
                'SECOND_NAME' => 'usersecondname',
            ]),
        ];

        $user = new CUser();
        foreach ($userFields as $fields) {
            $user->Add($fields);
        }
    }

    protected static function createUfs(): void
    {
        $commonFields = [
            'ENTITY_ID' => 'USER',
            'USER_TYPE_ID' => 'string',
        ];
        $ufFields = [
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_1'),
                'EDIT_FORM_LABEL' => [
                    'ru' => static::$prefix . 'uf_1',
                    'en' => '',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_2'),
                'LIST_COLUMN_LABEL' => [
                    'ru' => '',
                    'en' => static::$prefix . 'uf_2',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_3'),
                'LIST_FILTER_LABEL' => [
                    'ru' => static::$prefix . 'uf_3',
                    'en' => static::$prefix . 'uf_3',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_4'),
                'ERROR_MESSAGE' => [
                    'ru' => '',
                    'en' => '',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_5'),
                'LIST_COLUMN_LABEL' => [
                    'ru' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'uf_5',
                    'en' => '',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_6'),
                'ERROR_MESSAGE' => [
                    'ru' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'uf_6',
                    'en' => '',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_7'),
                'LIST_FILTER_LABEL' => [
                    'ru' => '',
                    'en' => TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'uf_7',
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_8'),
                'ERROR_MESSAGE' => [
                    'ru' => static::$prefix . 'uf_8' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                    'en' => static::$prefix . 'uf_8' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
                ],
            ]),
            array_merge($commonFields, [
                'FIELD_NAME' => strtoupper('uf_' . static::$prefix . 'uf_9'),
                'HELP_MESSAGE' => [
                    'ru' => static::$prefix . 'uf_9' . TestDataFilter::DEFAULT_FILTER_KEYWORD . 'extra',
                    'en' => '',
                ],
            ]),
        ];

        $ufField = new CUserTypeEntity();
        foreach ($ufFields as $fields) {
            $ufField->Add($fields);
        }
    }

    public static function remove(): void
    {
        static::removeUfs();
        static::removeUsers();
    }

    protected static function removeUsers(): void
    {
        $users = UserTable::getList(array(
            'filter' => array('LOGIN' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($users as $user) {
            CUser::Delete($user['ID']);
        }
    }

    protected static function removeUfs(): void
    {
        $ufs = UserFieldTable::getList([
            'filter' => ['FIELD_NAME' => '%' . static::$prefix . '%'],
            'select' => ['ID'],
        ])->fetchAll();

        $ufField = new CUserTypeEntity();
        foreach ($ufs as $uf) {
            $ufField->Delete($uf['ID']);
        }
    }
}