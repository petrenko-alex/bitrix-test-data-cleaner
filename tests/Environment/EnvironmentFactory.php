<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

use Exception;
use Petrenko\TestDataCleaner\Entities\BaseCleanableEntity;
use Petrenko\TestDataCleaner\Entities\CleanableIblockElement;

/**
 * Фабрика для классов тестового окружения
 *
 * @package Petrenko\TestDataCleaner\Tests\Environment;
 */
class EnvironmentFactory
{
    /**
     * Возвращает объект тестового окружения для тестируемой сущности.
     *
     * @param string $cleanableEntity класс тестируемой сущности - наследник BaseCleanableEntity.
     *
     * @return TestEnvironment объект класса тестового окружения.
     *
     * @throws Exception если для тестируемой сущности не найдено тестовое окружение.
     *
     * @see BaseCleanableEntity
     */
    public static function create(string $cleanableEntity) : TestEnvironment
    {
        switch ($cleanableEntity)
        {
            case CleanableIblockElement::class:
                return new IblockTestEnvironment();
            break;
            default:
                throw new Exception('Not supported class: ' . $cleanableEntity);
        }
    }
}