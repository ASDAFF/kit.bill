<?php
IncludeModuleLangFile(__FILE__);

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_client.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_client_partner.php');

class sotbit_bill extends CModule
{
    const MODULE_ID = 'sotbit.bill';
    var $MODULE_ID = 'sotbit.bill';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $PARTNER_NAME = '';
    var $PARTNER_URI = '';
    var $_1630639408 = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(dirname(__FILE__) . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = GetMessage(self::MODULE_ID . '_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage(self::MODULE_ID . '_MODULE_DESC');
        $this->PARTNER_NAME = GetMessage('sotbit.bill_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('sotbit.bill_PARTNER_URI');
    }

    function UnInstallEvents()
    {
        return true;
    }

    function DoInstall()
    {
        global $APPLICATION;
        $this->InstallFiles();
        $this->InstallDB();
        if ($_REQUEST['step'] == 1) {
            if ($_SERVER['SERVER_NAME']) {
                $_147471779 = $_SERVER['SERVER_NAME'];
            } elseif ($_SERVER['HTTP_HOST']) {
                $_147471779 = $_SERVER['HTTP_HOST'];
            }
            $_282267405 = '';
            $_1247816172 = \CUpdateClient::GetUpdatesList($_282267405);
            $_1326996569 = array(
                'ACTION' => 'ADD', 'SITE' => $_147471779,
                'KEY' => md5('BITRIX' . \CUpdateClientPartner::GetLicenseKey() . 'LICENCE'),
                'LICENSE' => $_1247816172['CLIENT'][0]['@']['LICENSE'],
                'MODULE' => self::MODULE_ID,
                'NAME' => $_REQUEST['Name'],
                'EMAIL' => $_REQUEST['Email'],
                'PHONE' => $_REQUEST['Phone'],
                'BITRIX_DATE_FROM' => $_1247816172['CLIENT'][0]['@']['DATE_FROM'],
                'BITRIX_DATE_TO' => $_1247816172['CLIENT'][0]['@']['DATE_TO'],
            );

            $_1252179561 = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/json; charset=utf-8',
                    'content' => json_encode($_1326996569))
            );
            $_479495201 = stream_context_create($_1252179561);
            $_1071917406 = file_get_contents('https://www.sotbit.ru:443/api/datacollection/index.php', 0, $_479495201);
            ModuleManager::registerModule(self::MODULE_ID);
            $this->InstallEvents();
        } else {
            $APPLICATION->IncludeAdminFile(GetMessage('INSTALL_TITLE'), $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/sotbit.bill/install/step.php');
        }
    }

    function InstallFiles($_1227038711 = array())
    {
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/admin', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin', true);
        if (is_dir($_1851053826 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/.default')) {
            if ($_465523322 = opendir($_1851053826)) {
                while (false !== $_856405953 = readdir($_465523322)) {
                    if ($_856405953 == '..' || $_856405953 == '.') continue;
                    CopyDirFiles($_1851053826 . '/' . $_856405953, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/' . $_856405953, $_1126829676 = True, $_1714020506 = True);
                }
                closedir($_465523322);
            }
        }
        if (is_dir($_1851053826 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/sale_payment/')) {
            if ($_465523322 = opendir($_1851053826)) {
                while (false !== $_856405953 = readdir($_465523322)) {
                    if ($_856405953 == '..' || $_856405953 == '.') continue;
                    CopyDirFiles($_1851053826 . '/' . $_856405953, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/sale_payment/' . $_856405953, $_1126829676 = True, $_1714020506 = True);
                }
                closedir($_465523322);
            }
        }
        if (is_dir($_1851053826 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/images/')) {
            if ($_465523322 = opendir($_1851053826)) {
                while (false !== $_856405953 = readdir($_465523322)) {
                    if ($_856405953 == '..' || $_856405953 == '.') continue;
                    CopyDirFiles($_1851053826 . '/' . $_856405953, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/images/sale/sale_payments/' . $_856405953, $_1126829676 = True, $_1714020506 = True);
                }
                closedir($_465523322);
            }
        }
        return true;
    }

    function InstallDB($_1227038711 = array())
    {
        $_756441553 = \Bitrix\Main\EventManager::getInstance();
        $_756441553->registerEventHandler('main', 'OnBeforeEventSend', self::MODULE_ID, 'BillSotbit', 'OnEmailHandler');
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function DoUninstall()
    {
        global $APPLICATION, $step;
        $step = IntVal($step);
        if (!isset($_REQUEST['step'])) {
            $APPLICATION->IncludeAdminFile(GetMessage(self::MODULE_ID . '_MODULE_INSTALL_TITLE'), $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/unstep1.php');
        } elseif ($_REQUEST['step'] == 2) {
            $this->UnInstallDB(array('savedata' => $_REQUEST['savedata'],));
            $this->UnInstallFiles();
            UnRegisterModule(self::MODULE_ID);
            $GLOBALS['errors'] = $this->_1474933575;
            $APPLICATION->IncludeAdminFile(GetMessage('_MODULE_INSTALL_TITLE'), $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/unstep2.php');
        }
    }

    function UnInstallDB($_1227038711 = array())
    {
        $_756441553 = \Bitrix\Main\EventManager::getInstance();
        $_756441553->unRegisterEventHandler('main', 'OnBeforeEventSend', self::MODULE_ID, 'BillSotbit', 'OnEmailHandler');
        if ($_1227038711['savedata'] != 'Y') {
            $_1883856963 = CFile::GetList(array('FILE_SIZE' => 'desc'), array('MODULE_ID' => 'sotbit.bill'));
            while ($_504773801 = $_1883856963->GetNext()) CFile::Delete($_504773801['ID']);
        }
        return true;
    }

    function UnInstallFiles($_1227038711 = array())
    {
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/.default/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default');
        if (is_dir($_1851053826 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/.default/')) {
            if ($_465523322 = opendir($_1851053826)) {
                while (false !== $_856405953 = readdir($_465523322)) {
                    if ($_856405953 == '..' || $_856405953 == '.' || !readdir($_1662693272 = $_1851053826 . '/' . $_856405953)) continue;
                    $_517135477 = is_dir($_1662693272);
                    while (false !== $_23393902 = readdir($_517135477)) {
                        if ($_23393902 == '..' || $_23393902 == '.') continue;
                        DeleteDirFilesEx('/bitrix/themes/.default/' . $_856405953 . '/' . $_23393902);
                    }
                    closedir($_517135477);
                }
                closedir($_465523322);
            }
        }
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/admin', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
        if (is_dir($_1851053826 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/sale_payment/')) {
            if ($_465523322 = opendir($_1851053826)) {
                while (false !== $_856405953 = readdir($_465523322)) {
                    if ($_856405953 == '..' || $_856405953 == '.' || !is_dir($_1662693272 = $_1851053826 . '/' . $_856405953)) continue;
                    $_517135477 = opendir($_1662693272);
                    while (false !== $_23393902 = readdir($_517135477)) {
                        if ($_23393902 == '..' || $_23393902 == '.') continue;
                        DeleteDirFilesEx('/bitrix/php_interface/include/sale_payment/' . $_856405953 . '/' . $_23393902);
                    }
                    closedir($_517135477);
                }
                closedir($_465523322);
            }
        }
        DeleteDirFilesEx('/bitrix/php_interface/include/sale_payment/billsotbit');
        return true;
    }
}