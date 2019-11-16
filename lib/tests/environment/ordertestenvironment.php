<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use Bitrix\Sale\Order;
use Bitrix\Sale\OrderTable;
use Petrenko\TestDataCleaner\TestDataFilter;

/**
 * Тестовое окружение для сущности заказа.
 */
class OrderTestEnvironment
{
    private static $prefix = 'petrenko_tdc_';

    public static function create(): void
    {
        global $USER;

        $orderDescriptions = [
            static::$prefix . 'o_1',
            TestDataFilter::DEFAULT_FILTER_KEYWORD . static::$prefix . 'o_2',
            static::$prefix . 'o_3 ' . TestDataFilter::DEFAULT_FILTER_KEYWORD,
            static::$prefix . 'o_4' . TestDataFilter::DEFAULT_FILTER_KEYWORD . ' extra',
        ];

        foreach ($orderDescriptions as $orderDescription)
        {
            $order = Order::create(SITE_ID, $USER->GetID());
            $order->setField('USER_DESCRIPTION', $orderDescription);
            $order->save();
        }
    }

    public static function remove(): void
    {
        $orders = OrderTable::getList([
            'filter' => ['USER_DESCRIPTION' => '%' . static::$prefix . '%'],
            'select' => ['ID'],
        ])->fetchAll();

        foreach ($orders as $order)
        {
            Order::delete($order['ID']);
        }
    }
}