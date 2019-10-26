<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class petrenko_testdatacleaner extends CModule
{
    const MINIMAL_VERSION_PHP = '7.1.0';
    //const MINIMAL_VERSION_BITRIX = '15.0.15';

    /**
     * @return string
     */
    public static function getModuleId()
    {
        return basename(dirname(__DIR__));
    }

    public function __construct()
    {
        // TODO: Lang vars
        // TODO: need to check bitrix minimal version?


        $arModuleVersion = array();
        include(dirname(__DIR__) . "/include.php");
        include(dirname(__FILE__) . "/version.php");
        $this->MODULE_ID = self::getModuleId();
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = 'TestDataCleaner';
        $this->MODULE_DESCRIPTION = 'Очистка тестовых данных';

        $this->PARTNER_NAME = 'petrenko';
        $this->PARTNER_URI = 'my_site.ru';
    }

    public function doInstall()
    {
        global $APPLICATION;
        if($this->checkMinRequirements())
        {
            try
            {
                Main\ModuleManager::registerModule($this->MODULE_ID);
            }
            catch (\Exception $e)
            {
                $APPLICATION->ThrowException($e->getMessage());

                return false;
            }

            return true;
        }
        else
        {
            return false;
        }
    }

    public function doUninstall()
    {
        try
        {
            Main\ModuleManager::unRegisterModule($this->MODULE_ID);
        }
        catch (\Exception $e)
        {
            global $APPLICATION;
            $APPLICATION->ThrowException($e->getMessage());

            return false;
        }

        return true;
    }

    private function checkMinRequirements()
    {
        // TODO: Lang vars (см пример в intervolga.migrato)

        global $APPLICATION;
        if (version_compare(phpversion(), self::MINIMAL_VERSION_PHP) < 0)
        {
            $APPLICATION->ThrowException('Версия php не корректная');

            return false;
        }

        return true;
    }
}