<?php namespace Petrenko\TestDataCleaner\Tests\Environment;

/**
 * Абстрактный класс тестового окружения.
 * Отвечает за создание и удаление данных БД для тестов.
 */
abstract class TestEnvironment
{
    /**
     * Подготавливает тестовое окружение:
     * создает данные в БД для тестов.
     */
    abstract public function create();

    /**
     * Освобождает тестовое окружение:
     * удаляет данные для тестов из БД.
     */
    abstract public function remove();
}