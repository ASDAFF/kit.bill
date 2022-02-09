<?

IncludeModuleLangFile(__FILE__);
class BillSotbit
{

    const MODULE_ID = 'sotbit.bill';
    const CACHE_TIME_TOOLS = 1800;

    function OnEmailHandler(&$arFields, &$arTemplate)
    {
        \CModule::includeModule('sale');
        if(isset($arFields['ORDER_REAL_ID']) && $arFields['ORDER_REAL_ID'] > 0)
        {
            $order = \Bitrix\Sale\Order::load($arFields['ORDER_REAL_ID']);
            $eventName = $arTemplate['EVENT_NAME'];
            $paymentCollection = $order->getPaymentCollection();
            $files = array();
            if(count($paymentCollection) > 0)
            {
                foreach ($paymentCollection as $payment)
                {
                    if (!$payment->isPaid())
                    {
                        $psID = $payment->getPaymentSystemId();
                        $action = \CSalePaySystem::GetByID($psID);
                        if ($action['ACTION_FILE'] == 'billsotbit')
                        {
                            $service = \Bitrix\Sale\PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
                            if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/bill_pdf')) mkdir($_SERVER['DOCUMENT_ROOT'].'/upload/bill_pdf');
                            $service->showTemplate($payment, 'template_pdf_file');


                            $pdfName = self::genBillName(
                                $order->getId(),
                                $order->getField("ACCOUNT_NUMBER"),
                                $order->getField('DATE_INSERT')->toString()
                            );


                            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/bill_pdf/' . $pdfName;

                            $arFile = \CFile::MakeFileArray($filePath);
                            $arFile['MODULE_ID'] = 'sotbit.bill';
                            $fid = \CFile::SaveFile($arFile , "sotbit.bill");
                            array_push($files, $fid);
                            unlink($filePath);
                        }
                    }
                }
                if (!empty($files))
                {
                    $events = unserialize(\COption::GetOptionString('sotbit.bill', 'EVENTS'));
                    if(in_array($eventName, $events))
                    {
                        $arTemplate['FILE'] = $files;
                    }
                }
            }
        }
    }


    public static function genBillName($orderId, $orderNumber, $orderDate)
    {
        $pdfName = \COption::GetOptionString('sotbit.bill', 'FILE_NAME');
        if(empty($pdfName))
            $pdfName = 'N#ORDER_ID#_#DATE#';

        if(!preg_match('/(#ORDER_ID#|#NUMBER#|#DATE#)/', $pdfName)) {
            $pdfName = $pdfName.'_#DATE#';
        }

        $pdfName = str_replace(
            ['#ORDER_ID#', '#NUMBER#', '#DATE#'],
            [$orderId, $orderNumber, $orderDate],
            $pdfName
        );

        $pdfName = str_replace(
            [
                chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(9), chr(10), chr(11),
                chr(12), chr(13), chr(14), chr(15), chr(16), chr(17), chr(18), chr(19), chr(20), chr(21), chr(22),
                chr(23), chr(24), chr(25), chr(26), chr(27), chr(28), chr(29), chr(30), chr(31),
                '"', '*', '/', ':', '<', '>', '?', '\\', '|', ' '
            ],
            '_',
            $pdfName
        );


        /*$filePath = $_SERVER['DOCUMENT_ROOT'] . '/upload/bill_pdf/' . $pdfName. '.pdf';
        if(is_file($filePath)) {
            $pdfName .= '_'.rand(1111111, 9999999);
        }*/

        return $pdfName.'.pdf';

    }
}