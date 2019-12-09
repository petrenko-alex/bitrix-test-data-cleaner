<?php namespace Petrenko\TestDataCleaner\Tests;

use Bitrix\Main\Loader;
use Petrenko\TestDataCleaner\Entities;
use Petrenko\TestDataCleaner\TestDataFilter;
use Petrenko\TestDataCleaner\Tests\Environment;

Loader::includeModule('petrenko.testdatacleaner');

class ServicePage
{
    // region Генерация тестовых окружений
    public static function generateTestEnvironments(): void
    {
        static::generateIblockTestEnvironment();
        static::generateUserTestEnvironment();
        static::generateHlbTestEnvironment();
        static::generateOrderTestEnvironment();
    }

    public static function generateIblockTestEnvironment(): void
    {
        Environment\IblockTestEnvironment::create();
    }

    public static function generateUserTestEnvironment(): void
    {
        Environment\UserTestEnvironment::create();
    }

    public static function generateHlbTestEnvironment(): void
    {
        Environment\HlbTestEnvironment::create();
    }

    public static function generateOrderTestEnvironment(): void
    {
        Environment\OrderTestEnvironment::create();
    }
    // endregion

    // region Очистка тестовых окружений
    public static function cleanTestEnvironments(): void
    {
        static::cleanIblockTestEnvironment();
        static::cleanUserTestEnvironment();
        static::cleanHlbTestEnvironment();
        static::cleanOrderTestEnvironment();
    }

    public static function cleanIblockTestEnvironment(): void
    {
        Environment\IblockTestEnvironment::remove();
    }

    public static function cleanUserTestEnvironment(): void
    {
        Environment\UserTestEnvironment::remove();
    }

    public static function cleanHlbTestEnvironment(): void
    {
        Environment\HlbTestEnvironment::remove();
    }

    public static function cleanOrderTestEnvironment(): void
    {
        Environment\OrderTestEnvironment::remove();
    }
    // endregion

    // region Поиск тестовых элементов
    public static function getTestIbTypes(): array
    {
        $testIblockType = new Entities\TestIblockType(new TestDataFilter());
        return $testIblockType->findElements();
    }

    public static function getTestIbs(): array
    {
        $testIb = new Entities\TestIblock(new TestDataFilter());
        return $testIb->findElements();
    }

    public static function getTestIbSections(): array
    {
        $testIbSection = new Entities\TestIblockSection(new TestDataFilter());
        return $testIbSection->findElements();
    }

    public static function getTestIbElements(): array
    {
        $testIbElement = new Entities\TestIblockElement(new TestDataFilter());
        return $testIbElement->findElements();
    }

    public static function getTestUsers(): array
    {
        $testUser = new Entities\TestUser(new TestDataFilter());
        return $testUser->findElements();
    }

    public static function getTestHlb(): array
    {
        $testHlb = new Entities\TestHlb(new TestDataFilter());
        return $testHlb->findElements();
    }

    public static function getTestIbProps(): array
    {
        $testIbProp = new Entities\TestIblockProperty(new TestDataFilter());
        return $testIbProp->findElements();
    }

    public static function getTestOrders(): array
    {
        $testOrder = new Entities\TestOrder(new TestDataFilter());
        return $testOrder->findElements();
    }

    public static function getTestUfs(): array
    {
        $testUf = new Entities\TestUf(new TestDataFilter());
        return $testUf->findElements();
    }
    // endregion

    // region Удаление тестовых элементов
    public static function cleanTestIbTypes(): void
    {
        $testIblockType = new Entities\TestIblockType(new TestDataFilter());
        $testIblockType->clean();
    }

    public static function cleanTestIbs(): void
    {
        $testIblock = new Entities\TestIblock(new TestDataFilter());
        $testIblock->clean();
    }

    public static function cleanTestIbSections(): void
    {
        $testIblockSection = new Entities\TestIblockSection(new TestDataFilter());
        $testIblockSection->clean();
    }

    public static function cleanTestIbElements(): void
    {
        $testIblockElement = new Entities\TestIblockElement(new TestDataFilter());
        $testIblockElement->clean();
    }

    public static function cleanTestUsers(): void
    {
        $testUser = new Entities\TestUser(new TestDataFilter());
        $testUser->clean();
    }

    public static function cleanTestHlb(): void
    {
        $testHlb = new Entities\TestHlb(new TestDataFilter());
        $testHlb->clean();
    }

    public static function cleanTestIbProps(): void
    {
        $testIbProp = new Entities\TestIblockProperty(new TestDataFilter());
        $testIbProp->clean();
    }

    public static function cleanTestOrders(): void
    {
        $order = new Entities\TestOrder(new TestDataFilter());
        $order->clean();
    }

    public static function cleanTestUfs(): void
    {
        $uf = new Entities\TestUf(new TestDataFilter());
        $uf->clean();
    }
    // endregion
}