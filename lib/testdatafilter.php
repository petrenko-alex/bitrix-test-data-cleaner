<?php namespace Petrenko\TestDataCleaner;

/**
 * Класс для создания строки фильтра для запроса тестовых данных.
 * Но основе настроек определения тестовых данных подготавливает строку фильтра
 * для запроса тестовых данных.
 *
 * @package Petrenko\TestDataCleaner
 */
class TestDataFilter
{
    protected $type = '';
    protected $keyword;

    public function __construct()
    {
        // TODO: Get from options: prefix or postfix
        // TODO: Get from options: keyword

        $this->keyword = '[test]';
        $this->type = 'prefix';
    }

    /**
     * Тип: префикс/постфикс.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Строка, идентифицирующее тестовые данные.
     *
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Возвращает строку для фильтра запроса тестовых данных.
     *
     * @return string
     */
    public function getFilter(): string
    {
        return $this->type == 'prefix'
            ? ($this->keyword . '%')
            : ('%' . $this->keyword);
    }
}