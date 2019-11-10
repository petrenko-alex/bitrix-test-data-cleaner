<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use CUser;
use Bitrix\Main\UserTable;
use Petrenko\TestDataCleaner\TestDataFilter;

/**
 * Тестовое окружение для сущности пользователей.
 */
class UserTestEnvironment
{
    private static $prefix = 'petrenko_tdc_';

    public static function create(): void
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
        foreach ($userFields as $fields)
        {
            $user->Add($fields);
        }
    }

    public static function remove(): void
    {
        $users = UserTable::getList(array(
            'filter' => array('LOGIN' => '%' . static::$prefix . '%'),
            'select' => array('ID'),
        ))->fetchAll();

        foreach ($users as $user)
        {
            CUser::Delete($user['ID']);
        }
    }
}