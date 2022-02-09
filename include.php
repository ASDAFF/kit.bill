<?

use Bitrix\Main\Request;
use Bitrix\Sale;
use Bitrix\Sale\PaySystem;

global $DBType;
$_1637186908 = 'kit.bill';
CModule::IncludeModule('sale');
CModule::AddAutoloadClasses($_1637186908,
    array(
        'BillKitOptions' => 'classes/general/CModuleOptions.php',
        'BillKit' => 'classes/general/BillKit.php'
    )
);

class BillHandler extends PaySystem\BaseServiceHandler
{
    public function initiatePay(Sale\Payment $_1488499059, Request $_827773463 = null)
    {
        $_1355684346 = $_1488499059->getCollection();
        $_19217209 = $_1355684346->getOrder();
        $_194852445 = $_1355684346->getPaidSum();
        $_1313953758 = $_1488499059->getSum();
        $_287390633 = 'template';
        if ($_REQUEST['PAYMENT_ID']) {
            $_1077947785 = $_827773463->get('PAYMENT_ID');
            if ($_1077947785) {
                $_1963523492 = 1;
                foreach ($_1355684346 as $_1687686178) {
                    if ($_1687686178->getId() == $_1077947785) {
                        break;
                    }
                    ++$_1963523492;
                }
            } else {
                $_1963523492 = 1;
            }
        } else {
            $_1963523492 = 1;
        }
        if (array_key_exists('pdf', $_REQUEST)) $_287390633 .= '_pdf';
        $_216833944 = (IsModuleInstalled('intranet')) ? $_19217209->getField('ACCOUNT_NUMBER') : $_1488499059->getField('ACCOUNT_NUMBER');
        $this->setExtraParams(array('ACCOUNT_NUMBER' => $_216833944, 'PAY' => $_1313953758, 'NUMBER' => $_1963523492));
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/upload/bill_pdf')) @mkdir($_SERVER['DOCUMENT_ROOT'] . '/upload/bill_pdf');
        $this->showTemplate($_1488499059, $_287390633);
        return $this->showTemplate($_1488499059, 'template_pdf_file');
    }

    public function getCurrencyList()
    {
        return array('RUB');
    }
}

?>