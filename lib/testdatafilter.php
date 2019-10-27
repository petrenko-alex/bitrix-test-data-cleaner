<?php namespace Petrenko\TestDataCleaner;

/**
 * Класс для создания строки фильтра для запроса тестовых данных.
 * Но основе настроек определения тестовых данных подготавливает строку фильтра
 * для запроса тестовых данных.
 *
 * TODO: Tests
 *
 * @package Petrenko\TestDataCleaner
 */
class TestDataFilter
{
    public const DEFAULT_FILTER_TYPE = 'prefix';
    public const DEFAULT_FILTER_KEYWORD = '[test]';

    protected $type = '';
    protected $keyword;

    public function __construct()
    {
        // TODO: Get from options: prefix or postfix
        // TODO: Get from options: keyword

        $this->type = static::DEFAULT_FILTER_TYPE;
        $this->keyword = static::DEFAULT_FILTER_KEYWORD;
    }

    /**
     * Возвращает объект с параметрами по умолчанию.
     *
     * @return TestDataFilter
     */
    public static function getDefault()
    {
        $testDataFilter = new static();
        $testDataFilter->setType(static::DEFAULT_FILTER_TYPE);
        $testDataFilter->setKeyword(static::DEFAULT_FILTER_KEYWORD);

        return $testDataFilter;
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

    /**
     * @param string $type
     *
     * @return TestDataFilter
     */
    protected function setType(string $type): TestDataFilter
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $keyword
     *
     * @return TestDataFilter
     */
    protected function setKeyword(string $keyword): TestDataFilter
    {
        $this->keyword = $keyword;

        return $this;
    }
}