<?php namespace Petrenko\TestDataCleaner\Entities;

use CUserTypeEntity;
use Bitrix\Main\Localization\Loc;

// TODO: PHP Doc
// TODO: move array_map in return of findElements to new func
class TestUf extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = $this->getUfs();
        $elements = $this->filterTestUfs($elements);

        return array_map(static function ($el) { return $el['ID']; }, $elements);
    }

    private function getUfs(): array
    {
        $ufData = $this->getUfData();
        $ufRusLangMessages = $this->getUfRusLangMessages();
        $ufEngLangMessages = $this->getUfEngLangMessages();

        foreach ($ufData as $ufId => &$uf) {
            $uf['LANG']['RU'] = $ufRusLangMessages[$ufId];
            $uf['LANG']['EN'] = $ufEngLangMessages[$ufId];
        }

        return $ufData;
    }

    private function getUfData(): array
    {
        $elements = [];

        $dbRes = CUserTypeEntity::GetList();
        while ($el = $dbRes->Fetch()) {
            $elements[$el['ID']] = $el;
        }

        return $elements;
    }

    private function getUfRusLangMessages(): array
    {
        return $this->getUfLangMessages('ru');
    }

    private function getUfEngLangMessages(): array
    {
        return $this->getUfLangMessages('en');
    }

    private function getUfLangMessages(string $lang): array
    {
        $dbRes = CUserTypeEntity::GetList([], ['LANG' => $lang]);

        $ufLangMessages = [];
        while ($el = $dbRes->Fetch()) {
            foreach ($this->getUfLangMessageKeys() as $ufLangMessageKey) {
                $ufLangMessages[$el['ID']][$ufLangMessageKey] = $el[$ufLangMessageKey];
            }
        }

        return $ufLangMessages;
    }

    private function filterTestUfs(array $allUfs): array
    {
        // TODO: func name
        return array_filter($allUfs, function ($ufData) {
            return $this->isTestUf($ufData);
        });
    }

    private function isTestUf(array $ufData): bool
    {
        return $this->isUfRusLangMessageMatchTestDataFilter($ufData['LANG'])
               || $this->isUfEngLangMessageMatchTestDataFilter($ufData['LANG']);
    }

    private function isUfRusLangMessageMatchTestDataFilter(array $ufLangMessages): bool
    {
        return $this->isUfLangMessageMatchTestDataFilter($ufLangMessages, 'RU');
    }

    private function isUfEngLangMessageMatchTestDataFilter(array $ufLangMessages): bool
    {
        return $this->isUfLangMessageMatchTestDataFilter($ufLangMessages, 'EN');
    }

    private function isUfLangMessageMatchTestDataFilter(array $ufLangMessages, string $lang): bool
    {
        $regex = $this->testDataFilter->getFilterRegex();

        foreach ($this->getUfLangMessageKeys() as $langMessageKey) {
            if (preg_match($regex, $ufLangMessages[$lang][$langMessageKey])) {
                return true;
            }
        }

        return false;
    }

    private function getUfLangMessageKeys(): array
    {
        return [
            'EDIT_FORM_LABEL',
            'LIST_COLUMN_LABEL',
            'LIST_FILTER_LABEL',
            'HELP_MESSAGE',
            'ERROR_MESSAGE',
        ];
    }

    protected function removeElements(): void
    {
        $ufField = new CUserTypeEntity();
        foreach ($this->elementsId as $elementId) {
            $ufField->Delete($elementId);
        }
    }

    public function getPublicName(): string
    {
        return Loc::getMessage('PETRENKO.TEST_DATA_CLEANER.ENTITIES.UF.NAME');
    }
}