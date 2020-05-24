<?php B_PROLOG_INCLUDED === true || die();

use Bitrix\Main\Localization\Loc;
use Petrenko\TestDataCleaner\TestDataCleaner;
use Petrenko\TestDataCleaner\EntitiesFactory;

\Bitrix\Main\Loader::includeModule('petrenko.testdatacleaner');

// TODO: refactor path
$APPLICATION->SetAdditionalCSS('/bitrix/gadgets/petrenko/testdatacleaner/style.css');

$cleaner = new TestDataCleaner(EntitiesFactory::getOrderedEntities());
$testData = $cleaner->get();

$elementsToClean = $testData['TOTAL_COUNT'];
?>

<div class="test-data-cleaner">
    <? if (!$elementsToClean) : ?>
        <div class="test-data-cleaner__header">
            <p class="bx-gadget-gray text-center">
                <?= Loc::getMessage('PETRENKO.TEST_DATA_CLEANER.NO_TEST_ELEMENTS') ?>
            </p>
        </div>
    <? else: ?>
        <div class="test-data-cleaner__header">
            <p class="w-70">
                <?
                echo Loc::getMessage(
                    'PETRENKO.TEST_DATA_CLEANER.ELEMENTS_TO_CLEAN',
                    ['#COUNT#' => $elementsToClean]
                )
                ?>
            </p>
            <div class="test-data-cleaner__total-clean">
                <input type="submit" class="adm-btn-save" value="Очистить все">
            </div>
        </div>
        <div class="delimiter"></div>
        <? foreach ($testData['ENTITIES'] as $testEntity) : ?>
            <div class="test-data-cleaner__entity">
                <div class="test-data-cleaner__name">
                    <?= $testEntity['PUBLIC_NAME'] ?>
                </div>
                <div class="test-data-cleaner__count">
                    <?= $testEntity['COUNT'] ?>
                </div>
                <div class="test-data-cleaner__clean">
                    <input type="submit" class="adm-btn-save" value="Очистить">
                </div>
            </div>
        <? endforeach; ?>
    <? endif; ?>
</div>
