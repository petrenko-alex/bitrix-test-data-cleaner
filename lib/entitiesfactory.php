<?php namespace Petrenko\TestDataCleaner;

use Petrenko\TestDataCleaner\Entities;

class EntitiesFactory
{
    /**
     * Возвращает класс тестовой сущнности по ее имени.
     *
     * @param string $entityName
     *
     * @return string
     */
    public static function getClassByName(string $entityName): string
    {
        return static::getEntityNameToClassMap()[$entityName] ?: '';
    }

    /**
     * Возвращает названия тестовых сущностей в правильном порядке.
     *
     * @return array
     */
    public static function getOrderedEntities(): array
    {
        return [
            'order',
            'user',
            'iblockelement',
            'iblocksection',
            'iblockprop',
            'iblock',
            'iblocktype',
            'hlblock',
            'uf',
        ];
    }

    /**
     * Возвращает классы тестовых сущностей в правильном порядке.
     *
     * @return array
     */
    public static function getOrderedEntityClasses(): array
    {
        return [
            Entities\TestOrder::class,
            Entities\TestUser::class,
            Entities\TestIblockElement::class,
            Entities\TestIblockSection::class,
            Entities\TestIblockProperty::class,
            Entities\TestIblock::class,
            Entities\TestIblockType::class,
            Entities\TestHlb::class,
            Entities\TestUf::class,
        ];
    }

    /**
     * Возвращает карту соответствия названий тестовых сущностей
     * их классам.
     *
     * @return array
     */
    public static function getEntityNameToClassMap(): array
    {
        return array_combine(static::getOrderedEntities(), static::getOrderedEntityClasses());
    }
}