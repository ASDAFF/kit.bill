<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arPaySysAction["ENCODING"] = "";

if (!CSalePdf::isPdfAvailable())
    die();

if ($_REQUEST['BLANK'] == 'Y')
    $blank = true;

if($params['NUMBER'])
{
    $params['NUMBER'] = '/'.$params['NUMBER'];
}

function EditData ($DATA)
{
    $MES = array(
        "01" => Loc::getMessage('SELLER_COMPANY_JANUARY_KIT'),
        "02" => Loc::getMessage('SELLER_COMPANY_FEBRUARY_KIT'),
        "03" => Loc::getMessage('SELLER_COMPANY_MARCH_KIT'),
        "04" => Loc::getMessage('SELLER_COMPANY_APRIL_KIT'),
        "05" => Loc::getMessage('SELLER_COMPANY_MAY_KIT'),
        "06" => Loc::getMessage('SELLER_COMPANY_JUNE_KIT'),
        "07" => Loc::getMessage('SELLER_COMPANY_JULY_KIT'),
        "08" => Loc::getMessage('SELLER_COMPANY_AUGUST_KIT'),
        "09" => Loc::getMessage('SELLER_COMPANY_SEPTEMBER_KIT'),
        "10" => Loc::getMessage('SELLER_COMPANY_OCTOBER_KIT'),
        "11" => Loc::getMessage('SELLER_COMPANY_NOVEMBER_KIT'),
        "12" => Loc::getMessage('SELLER_COMPANY_DECEMBER_KIT')
    );
    $arData = explode(".", $DATA);
    $d = ($arData[0] < 10) ? substr($arData[0], 1) : $arData[0];

    $newData = $d." ".$MES[$arData[1]]." ".$arData[2];
    return $newData;
}

/** @var CSaleTfpdf $pdf */
$pdf = new CSalePdf('P', 'pt', 'A4');

if ($params['BILL_BACKGROUND_KIT'])
{
    $pdf->SetBackground(
        $params['BILL_BACKGROUND_KIT'],
        $params['BILL_BACKGROUND_STYLE_KIT']
    );
}

$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);

$fontFamily = 'Font';
$fontSize   = 10.5;

$margin = array(
    'top' => intval($params['BILL_MARGIN_TOP_KIT'] ?: 15) * 72/25.4,
    'right' => intval($params['BILL_MARGIN_RIGHT_KIT'] ?: 15) * 72/25.4,
    'bottom' => intval($params['BILL_MARGIN_BOTTOM_KIT'] ?: 15) * 72/25.4,
    'left' => intval($params['BILL_MARGIN_LEFT_KIT'] ?: 20) * 72/25.4
);

$width = $pageWidth - $margin['left'] - $margin['right'];

$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);

$pdf->AddPage();


$y0 = $pdf->GetY();
$logoHeight = 0;
$logoWidth = 0;

if ($params['BILL_HEADER_SHOW_KIT'] == 'Y')
{
    if ($params['BILL_PATH_TO_LOGO_KIT'])
    {
        list($imageHeight, $imageWidth) = $pdf->GetImageSize($params['BILL_PATH_TO_LOGO_KIT']);

        $imgDpi = intval($params['BILL_LOGO_DPI_KIT']) ?: 96;
        $imgZoom = 96 / $imgDpi;

        $logoHeight = $imageHeight * $imgZoom + 5;
        $logoWidth  = $imageWidth * $imgZoom + 5;

        $pdf->Image($params['BILL_PATH_TO_LOGO_KIT'], $pdf->GetX(), $pdf->GetY(), -$imgDpi, -$imgDpi);
    }

    $pdf->SetFont($fontFamily, '', $fontSize);

    $text = CSalePdf::prepareToPdf($params["SELLER_COMPANY_NAME_KIT"]);

    $textWidth = $width - $logoWidth;
    while ($pdf->GetStringWidth($text))
    {
        list($string, $text) = $pdf->splitString($text, $textWidth);
        $pdf->SetX($pdf->GetX() + $logoWidth);
        $pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
        $pdf->Ln();$pdf->Ln();
    }

    if ($params["SELLER_COMPANY_ADDRESS_KIT"])
    {
        $sellerAddr = $params["SELLER_COMPANY_ADDRESS_KIT"];
        if (is_array($sellerAddr))
            $sellerAddr = implode(', ', $sellerAddr);
        else
            $sellerAddr = str_replace(array("\r\n", "\n", "\r"), ', ', strval($sellerAddr));
        $pdf->SetX($pdf->GetX() + $logoWidth);
        $pdf->MultiCell(0, 15, CSalePdf::prepareToPdf($sellerAddr), 0, 'L');
    }

    if ($params["SELLER_COMPANY_PHONE_KIT"])
    {
        $text = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_COMPANY_PHONE', array('#PHONE#' => $params["SELLER_COMPANY_PHONE_KIT"])));
        $textWidth = $width - $logoWidth;
        while ($pdf->GetStringWidth($text))
        {
            list($string, $text) = $pdf->splitString($text, $textWidth);
            $pdf->SetX($pdf->GetX() + $logoWidth);
            $pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
            $pdf->Ln();
        }
    }


    if ($params["SELLER_COMPANY_EMAIL_KIT"])
    {
        $text = CSalePdf::prepareToPdf(Loc::getMessage('SELLER_COMPANY_EMAIL_KIT', array('#EMAIL#' => $params["SELLER_COMPANY_EMAIL_KIT"])));
        $textWidth = $width - $logoWidth;
        while ($pdf->GetStringWidth($text))
        {
            list($string, $text) = $pdf->splitString($text, $textWidth);
            $pdf->SetX($pdf->GetX() + $logoWidth);
            $pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
            $pdf->Ln();
        }
    }

    if ($params["SELLER_COMPANY_SITE_KIT"])
    {
        $text = CSalePdf::prepareToPdf(Loc::getMessage('SELLER_COMPANY_SITE_KIT', array('#SITE#' => $params["SELLER_COMPANY_SITE_KIT"])));
        $textWidth = $width - $logoWidth;
        while ($pdf->GetStringWidth($text))
        {
            list($string, $text) = $pdf->splitString($text, $textWidth);
            $pdf->SetX($pdf->GetX() + $logoWidth);
            $pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
            $pdf->Ln();
        }
    }

    $pdf->Ln();
    if ($params["BILL_ORDER_HEADER_TITLE_KIT"])
    {
        $text = CSalePdf::prepareToPdf($params["BILL_ORDER_HEADER_TITLE_KIT"]);
        $textWidth = $width - $logoWidth;
        while ($pdf->GetStringWidth($text))
        {
            list($string, $text) = $pdf->splitString($text, $textWidth);
            $pdf->SetX($pdf->GetX() + $logoWidth);
            $pdf->Cell($textWidth, 15, $string, 0, 0, 'L');
            $pdf->Ln();
        }
    }


    $pdf->Ln();
    $pdf->SetY(max($y0 + $logoHeight, $pdf->GetY()));

    if ($params["SELLER_COMPANY_BANK_NAME_KIT"])
    {
        $sellerBankCity = '';
        if ($params["SELLER_COMPANY_BANK_CITY_KIT"])
        {
            $sellerBankCity = $params["SELLER_COMPANY_BANK_CITY_KIT"];
            if (is_array($sellerBankCity))
                $sellerBankCity = implode(', ', $sellerBankCity);
            else
                $sellerBankCity = str_replace(array("\r\n", "\n", "\r"), ', ', strval($sellerBankCity));
        }
        $sellerBank = sprintf(
            "%s %s",
            $params["SELLER_COMPANY_BANK_NAME_KIT"],
            $sellerBankCity
        );
        unset($sellerBankCity);
        $sellerRs = $params["SELLER_COMPANY_BANK_ACCOUNT_KIT"];
    }
    else
    {
        $rsPattern = '/\s*\d{10,100}\s*/';

        $sellerBank = trim(preg_replace($rsPattern, ' ', $params["SELLER_COMPANY_BANK_ACCOUNT_KIT"]));

        preg_match($rsPattern, $params["SELLER_COMPANY_BANK_ACCOUNT_KIT"], $matches);
        $sellerRs = trim($matches[0]);
    }

    $pdf->SetFont($fontFamily, '', $fontSize);

    $x0 = $pdf->GetX();
    $y0 = $pdf->GetY();

    //bank
    $text = CSalePdf::prepareToPdf($sellerBank);
    while ($pdf->GetStringWidth($text) > 0)
    {
        list($string, $text) = $pdf->splitString($text, 300-5);

        $pdf->Cell(300, 18, $string);
        if ($text)
            $pdf->Ln();
    }
    $x1 = $pdf->GetX();
    $pdf->Cell(
        50, 18,
        CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_BANK_BIK'))
    );
    $x2 = $pdf->GetX();
    $pdf->Cell(
        0, 18,
        CSalePdf::prepareToPdf($params["SELLER_COMPANY_BANK_BIC_KIT"])
    );
    $x3 = $pdf->GetX();

    $pdf->Ln();
    $y1 = $pdf->GetY();




    //bank2
    $pdf->Cell(
        300, 18,
        CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_BANK_NAME'))
    );
    $x1 = $pdf->GetX();
    $pdf->Cell(
        50, 18,
        CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_ACC'))
    );
    $x2 = $pdf->GetX();
    $pdf->Cell(
        50, 18,
        CSalePdf::prepareToPdf($params["SELLER_COMPANY_BANK_ACCOUNT_CORR_KIT"])
    );
    $x3 = $pdf->GetX();
    $pdf->Ln();
    $y2 = $pdf->GetY();


    $pdf->Line($x1, $y0, $x1, $y2);
    $pdf->Line($x1, $y1, $x2, $y1);
    $pdf->Line($x2, $y0, $x2, $y2);

    //inn
    $pdf->Cell(
        50, 18,
        ($params["SELLER_COMPANY_INN_KIT"])
            ? CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_INN'))
            : ''
    );
    $x1 = $pdf->GetX();
    $pdf->Cell(
        100, 18,
        ($params["SELLER_COMPANY_INN_KIT"])
            ? CSalePdf::prepareToPdf($params["SELLER_COMPANY_INN_KIT"])
            : ''
    );
    $x2 = $pdf->GetX();
    $pdf->Cell(
        50, 18,
        CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_KPP'))
    );
    $x3 = $pdf->GetX();
    $pdf->Cell(
        100, 18,
        ($params["SELLER_COMPANY_KPP_KIT"])
            ? CSalePdf::prepareToPdf($params["SELLER_COMPANY_KPP_KIT"])
            : ''
    );
    $x4 = $pdf->GetX();
    $pdf->Cell(50, 18,CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_ACC_CORR')));
    $x5 = $pdf->GetX();
    $pdf->Cell(0, 18,CSalePdf::prepareToPdf($sellerRs));

    $x6 = $pdf->GetX();

    $pdf->Line($x0, $y2, $x6, $y2);

    $pdf->Ln();

    $y3 = $pdf->GetY();

    $pdf->Line($x1, $y2, $x1, $y3);
    $pdf->Line($x2, $y2, $x2, $y3);
    $pdf->Line($x3, $y2, $x3, $y3);
    $pdf->Line($x4, $y2, $x4, $y3);
    $pdf->Line($x0, $y3, $x4, $y3);

    //ip
    $text = CSalePdf::prepareToPdf($params["SELLER_COMPANY_NAME_KIT"]);
    while ($pdf->GetStringWidth($text) > 0)
    {
        list($string, $text) = $pdf->splitString($text, 300-5);

        $pdf->Cell(300, 18, $string);
        if ($text)
            $pdf->Ln();
    }
    $x1 = $pdf->GetX();
    $pdf->Cell(50, 18);
    $x2 = $pdf->GetX();
    $pdf->Cell(0, 18);
    $x3 = $pdf->GetX();
    $pdf->Ln();
    $y4 = $pdf->GetY();

    //ip2
    $pdf->Cell(300, 18,CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_NAME')));
    $x1 = $pdf->GetX();
    $pdf->Cell(50, 18);
    $x2 = $pdf->GetX();
    $pdf->Cell(0, 18);
    $x3 = $pdf->GetX();
    $pdf->Ln();
    $y5 = $pdf->GetY();

    $pdf->Line($x0, $y0, $x3, $y0);
    $pdf->Line($x3, $y0, $x3, $y5);
    $pdf->Line($x0, $y5, $x3, $y5);
    $pdf->Line($x0, $y0, $x0, $y5);

    $pdf->Line($x1, $y2, $x1, $y5);
    $pdf->Line($x2, $y2, $x2, $y5);


}

$pdf->Ln();
$pdf->Ln();

/** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
$paymentCollection = $payment->getCollection();

/** @var \Bitrix\Sale\Order $order */
$order = $paymentCollection->getOrder();


$PersonType = $order->getPersonTypeId();

/** @var \Bitrix\Sale\Basket $basket */
$basket = $order->getBasket();


if ($params['BILL_HEADER_KIT'])
{
    $pdf->SetFont($fontFamily, 'B', $fontSize * 2);
    $billNo_tmp = CSalePdf::prepareToPdf(
        $params['BILL_HEADER_KIT'].' '.Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_TITLE', array('#PAYMENT_NUM#' => $order->getField('ACCOUNT_NUMBER'), '#PAYMENT_DATE#' => EditData($params["PAYMENT_DATE_INSERT"]), '#NUMBER#' => $params['NUMBER']))
    );

    $billNo_width = $pdf->GetStringWidth($billNo_tmp);
    $pdf->Cell(0, 20, $billNo_tmp, 0, 0, 'C');
    $pdf->Ln();
}
$pdf->SetFont($fontFamily, '', $fontSize);

if ($params["BILL_ORDER_SUBJECT_KIT"])
{
    $pdf->Cell($width/2-$billNo_width/2-2, 15, '');
    $pdf->MultiCell(0, 15, CSalePdf::prepareToPdf($params["BILL_ORDER_SUBJECT_KIT"]), 0, 'L');
}

if ($params["PAYMENT_DATE_PAY_BEFORE"])
{
    $pdf->Cell($width/2-$billNo_width/2-2, 15, '');
    $pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(
        Loc::getMessage('SALE_HPS_BILL_KIT_SELLER_DATE_END', array('#PAYMENT_DATE_END#' => ConvertDateTime($params["PAYMENT_DATE_PAY_BEFORE_KIT"], FORMAT_DATE) ?: $params["PAYMENT_DATE_PAY_BEFORE_KIT"]))), 0, 'L');
}

$pdf->Ln();
$y0 = $pdf->GetY();
$pdf->Cell(70, 18,CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SALE_NAME')));
$x1 = $pdf->GetX();
$pdf->Cell(0, 18, CSalePdf::prepareToPdf($params["SELLER_COMPANY_NAME_KIT"]));
$pdf->Ln();





$str= '';
if ($params['BILL_PAYER_SHOW_KIT'] == 'Y')
{
    $pdf->Cell(70, 18,CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_BUYER_NAME')));
    if ($params["BUYER_PERSON_COMPANY_NAME_KIT"])
    {
        $str = '';
        if($PersonType == 1)
        {
            if ($params["BUYER_PERSON_COMPANY_LAST_NAME_KIT"])
                $str.= $params["BUYER_PERSON_COMPANY_LAST_NAME_KIT"].' ';
            if ($params["BUYER_PERSON_COMPANY_NAME_KIT"])
                $str.= $params["BUYER_PERSON_COMPANY_NAME_KIT"].' ';
        }
        else
        {
            if ($params["BUYER_PERSON_COMPANY_NAME_KIT"])
                $str.= $params["BUYER_PERSON_COMPANY_NAME_KIT"];
            if ($params["BUYER_PERSON_COMPANY_NAME_CONTACT_KIT"])
                $str.= ','. $params["BUYER_PERSON_COMPANY_NAME_CONTACT_KIT"];
            if ($params["BUYER_PERSON_COMPANY_INN_KIT"])
                $str.= ','.\Bitrix\Main\Localization\Loc::getMessage("SALE_HPS_BILL_KIT_BUYER_INN",array('#INN#'=>$params["BUYER_PERSON_COMPANY_INN_KIT"]));
            if ($params["BUYER_PERSON_COMPANY_KPP_KIT"])
                $str.= ','.\Bitrix\Main\Localization\Loc::getMessage("SALE_HPS_BILL_KIT_BUYER_KPP",array('#KPP#'=>$params["BUYER_PERSON_COMPANY_KPP_KIT"]));
            if ($params["BUYER_PERSON_COMPANY_OGRN_KIT"])
                $str.= ','.\Bitrix\Main\Localization\Loc::getMessage("SALE_HPS_BILL_KIT_BUYER_OGRN",array('#OGRN#'=>$params["BUYER_PERSON_COMPANY_OGRN_KIT"]));
            if ($params["BUYER_PERSON_COMPANY_PHONE_KIT"])
                $str.= ','.\Bitrix\Main\Localization\Loc::getMessage("SALE_HPS_BILL_KIT_BUYER_PHONE",array('#PHONE#'=>$params["BUYER_PERSON_COMPANY_PHONE_KIT"]));
            if ($params["BUYER_PERSON_COMPANY_ADDRESS_KIT"])
                $str.= ','.\Bitrix\Main\Localization\Loc::getMessage("SALE_HPS_BILL_KIT_BUYER_ADDRESS",array('#ADDRESS#'=>$params["BUYER_PERSON_COMPANY_ADDRESS_KIT"]));
            if ($params["BUYER_PERSON_COMPANY_FAX_KIT"])
                $str.= ','.\Bitrix\Main\Localization\Loc::getMessage("SALE_HPS_BILL_KIT_BUYER_FAX",array('#FAX#'=>$params["BUYER_PERSON_COMPANY_FAX_KIT"]));
        }

        $pdf->MultiCell(0, 18, CSalePdf::prepareToPdf($str));
        $pdf->Ln();
    }
}



$arCurFormat = CCurrencyLang::GetCurrencyFormat($payment->getField('CURRENCY'));
$currency = preg_replace('/(^|[^&])#/', '${1}', $arCurFormat['FORMAT_STRING']);
$currency = strip_tags($currency);

$columnList = array('NUMBER', 'NAME', 'QUANTITY', 'MEASURE', 'PRICE', 'VAT_RATE', 'SUM');
$arColsCaption = array();
$vatRateColumn = 0;
foreach ($columnList as $column)
{
    if ($params['BILL_COLUMN_'.$column.'_SHOW_KIT'] == 'Y')
    {
        $arColsCaption[$column] = CSalePdf::prepareToPdf($params['BILL_COLUMN_'.$column.'_TITLE_KIT']);
        /*if (in_array($column, array('PRICE', 'SUM')))
          $arColsCaption[$column] .= ', '.CSalePdf::prepareToPdf($currency);*/
    }
}
$arColumnKeys = array_keys($arColsCaption);
$columnCount = count($arColumnKeys);

if (count($basket->getBasketItems()) > 0)
{
    $arCells = array();
    $arProps = array();
    $arRowsWidth = array();

    foreach ($arColsCaption as $columnId => $caption)
        $arRowsWidth[$columnId] = 0;

    foreach ($arColsCaption as $columnId => $caption)
        $arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($caption));

    $n = 0;
    $sum = 0.00;
    $vat = 0;
    /** @var \Bitrix\Sale\BasketItem $basketItem */
    foreach ($basket->getBasketItems() as $basketItem)
    {
        $productName = $basketItem->getField("NAME");
        if ($productName == "OrderDelivery")
            $productName = Loc::getMessage('SALE_HPS_BILL_KIT_DELIVERY');
        else if ($productName == "OrderDiscount")
            $productName = Loc::getMessage('SALE_HPS_BILL_KIT_DISCOUNT');

        if ($basketItem->isVatInPrice())
            $basketItemPrice = $basketItem->getPrice();
        else
            $basketItemPrice = $basketItem->getPrice()*(1 + $basketItem->getVatRate());

        $arCells[++$n] = array();
        foreach ($arColsCaption as $columnId => $caption)
        {
            $data = null;

            switch ($columnId)
            {
                case 'NUMBER':
                    $data = CSalePdf::prepareToPdf($n);
                    break;
                case 'NAME':
                    $data = CSalePdf::prepareToPdf($productName);
                    break;
                case 'QUANTITY':
                    $data = CSalePdf::prepareToPdf(roundEx($basketItem->getQuantity(), SALE_VALUE_PRECISION));
                    break;
                case 'MEASURE':
                    $data = CSalePdf::prepareToPdf($basketItem->getField("MEASURE_NAME") ? $basketItem->getField("MEASURE_NAME") : Loc::getMessage('SALE_HPS_BILL_KIT_BASKET_MEASURE_DEFAULT'));
                    break;
                case 'PRICE':
                    $data = CSalePdf::prepareToPdf(SaleFormatCurrency($basketItem->getPrice(), $basketItem->getCurrency(), true));
                    break;
                case 'VAT_RATE':
                    $data = CSalePdf::prepareToPdf(roundEx($basketItem->getVatRate()*100, SALE_VALUE_PRECISION)."%");
                    break;
                case 'SUM':
                    $data = CSalePdf::prepareToPdf(SaleFormatCurrency($basketItemPrice * $basketItem->getQuantity(), $basketItem->getCurrency(), true));
                    break;
            }
            if ($data !== null)
                $arCells[$n][$columnId] = $data;
        }

        $arProps[$n] = array();
        /** @var \Bitrix\Sale\BasketPropertyItem $basketPropertyItem */
        foreach ($basketItem->getPropertyCollection() as $basketPropertyItem)
        {
            if ($basketPropertyItem->getField('CODE') == 'CATALOG.XML_ID' || $basketPropertyItem->getField('CODE') == 'PRODUCT.XML_ID')
                continue;

            $arProps[$n][] = $pdf::prepareToPdf(sprintf("%s: %s", $basketPropertyItem->getField("NAME"), $basketPropertyItem->getField("VALUE")));
        }

        foreach ($arColsCaption as $columnId => $caption)
            $arRowsWidth[$columnId] = max($arRowsWidth[$columnId], $pdf->GetStringWidth($arCells[$n][$columnId]));

        $sum += doubleval($basketItem->getPrice() * $basketItem->getQuantity());
        $vat = max($vat, $basketItem->getVatRate());
    }

    if ($vat <= 0)
    {
        unset($arColsCaption['VAT_RATE']);
        $columnCount = count($arColsCaption);
        $arColumnKeys = array_keys($arColsCaption);
        foreach ($arCells as $i => $cell)
            unset($arCells[$i]['VAT_RATE']);
    }

    /** @var \Bitrix\Sale\ShipmentCollection $shipmentCollection */
    $shipmentCollection = $order->getShipmentCollection();

    $shipment = null;
    /** @var \Bitrix\Sale\Shipment $shipmentItem */
    foreach ($shipmentCollection as $shipmentItem)
    {
        if (!$shipmentItem->isSystem())
        {
            $shipment = $shipmentItem;
            break;
        }
    }

    if ($shipment !== null && $shipment->getPrice() > 0)
    {
        $sDeliveryItem = Loc::getMessage('SALE_HPS_BILL_KIT_DELIVERY');
        if ($shipment->getDeliveryName())
            $sDeliveryItem .= sprintf(" (%s)", $shipment->getDeliveryName());
        $arCells[++$n] = array();
        foreach ($arColsCaption as $columnId => $caption)
        {
            $data = null;

            switch ($columnId)
            {
                case 'NUMBER':
                    $data = CSalePdf::prepareToPdf($n);
                    break;
                case 'NAME':
                    $data = CSalePdf::prepareToPdf($sDeliveryItem);
                    break;
                case 'QUANTITY':
                    $data = CSalePdf::prepareToPdf(1);
                    break;
                case 'MEASURE':
                    $data = CSalePdf::prepareToPdf('');
                    break;
                case 'PRICE':
                    $data = CSalePdf::prepareToPdf(SaleFormatCurrency($shipment->getPrice(), $shipment->getCurrency(), true));
                    break;
                case 'VAT_RATE':
                    $data = CSalePdf::prepareToPdf(roundEx($vat*100, SALE_VALUE_PRECISION)."%");
                    break;
                case 'SUM':
                    $data = CSalePdf::prepareToPdf(SaleFormatCurrency($shipment->getPrice(), $shipment->getCurrency(), true));
                    break;
            }
            if ($data !== null)
                $arCells[$n][$columnId] = $data;
        }

        for ($i = 1; $i <= $columnCount; $i++)
            $arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arCells[$n][$i]));

        $sum += doubleval($shipment->getPrice());
    }

    $cntBasketItem = $n;
    if ($params['BILL_TOTAL_SHOW_KIT'] == 'Y')
    {
        if ($sum < $payment->getSum())
        {
            $arCells[++$n] = array();
            for ($i = 0; $i < $columnCount; $i++)
                $arCells[$n][$arColumnKeys[$i]] = null;

            $arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_SUBTOTAL'));
            $arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($sum, $payment->getField('CURRENCY'), true));

            $arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
        }

		$taxes = false;
		$taxesList = [];
		$dbTaxList = CSaleOrderTax::GetList(
			array("APPLY_ORDER" => "ASC"),
			array("ORDER_ID" => $order->getId())
		);

		while ($tax = $dbTaxList->Fetch())
		{
			$taxesList[] = $tax;
			$taxes = true;

			$arCells[++$n] = [];
			for ($i = 0; $i < $columnCount; $i++)
				$arCells[$n][$arColumnKeys[$i]] = null;

			$arCells[$n][$arColumnKeys[$columnCount - 2]] = CSalePdf::prepareToPdf(sprintf(
				"%s%s%s:",
				($tax["IS_IN_PRICE"] == "Y") ? Loc::getMessage('SALE_HPS_BILL_KIT_INCLUDING') : "",
				$tax["TAX_NAME"],
				($vat <= 0 && $tax["IS_PERCENT"] == "Y") ? sprintf(' (%s%%)', roundEx($tax["VALUE"], SALE_VALUE_PRECISION)) : ""
			));
			$arCells[$n][$arColumnKeys[$columnCount - 1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($tax["VALUE_MONEY"], $payment->getField('CURRENCY'), true));

			$arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
		}

		if (!$taxes)
        {
            $arCells[++$n] = array();
            for ($i = 0; $i < $columnCount; $i++)
                $arCells[$n][$arColumnKeys[$i]] = null;

            $arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_TOTAL_VAT_RATE'));
            $arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_TOTAL_VAT_RATE_NO'));

            $arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
        }

        $sumPaid = $paymentCollection->getPaidSum();

        if (DoubleVal($sumPaid) > 0)
        {
            $arCells[++$n] = array();
            for ($i = 0; $i < $columnCount; $i++)
                $arCells[$n][$arColumnKeys[$i]] = null;

            $arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_TOTAL_PAID'));
            $arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($sumPaid, $payment->getField('CURRENCY'), true));

            $arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
        }

        if (DoubleVal($order->getDiscountPrice()) > 0)
        {
            $arCells[++$n] = array();
            for ($i = 0; $i < $columnCount; $i++)
                $arCells[$n][$arColumnKeys[$i]] = null;

            $arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_TOTAL_DISCOUNT'));
            $arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($order->getDiscountPrice(), $order->getCurrency(), true));

            $arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
        }


        $arCells[++$n] = array();
        for ($i = 0; $i < $columnCount; $i++)
            $arCells[$n][$arColumnKeys[$i]] = null;

        $arCells[$n][$arColumnKeys[$columnCount-2]] = CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_TOTAL_SUM'));
        $arCells[$n][$arColumnKeys[$columnCount-1]] = CSalePdf::prepareToPdf(SaleFormatCurrency($payment->getSum(), $payment->getField('CURRENCY'), true));

        $arRowsWidth[$arColumnKeys[$columnCount]] = max($arRowsWidth[$columnCount], $pdf->GetStringWidth($arCells[$n][$columnCount]));
    }

    foreach ($arColsCaption as $columnId => $caption)
        $arRowsWidth[$columnId] += 10;
    if ($vat <= 0)
        $arRowsWidth['VAT_RATE'] = 0;
    if (array_key_exists('NAME', $arColsCaption))
        $arRowsWidth['NAME'] = $width - (array_sum($arRowsWidth)-$arRowsWidth['NAME']);

}
$pdf->Ln();

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();

foreach ($arColsCaption as $columnId => $column)
{
    if ($vat > 0 || $columnId !== 'VAT_RATE')
        $pdf->Cell($arRowsWidth[$columnId], 20, $column, 0, 0, 'C');
    $i = array_search($columnId, $arColumnKeys);
    ${"x".($i+1)} = $pdf->GetX();
}

$pdf->Ln();

$y5 = $pdf->GetY();

$pdf->Line($x0, $y0, ${"x".$columnCount}, $y0);
for ($i = 0; $i <= $columnCount; $i++)
{
    if ($vat > 0 || $arColumnKeys[$i] != 'VAT_RATE')
        $pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
}
$pdf->Line($x0, $y5, ${'x'.$columnCount}, $y5);

$rowsCnt = count($arCells);
for ($n = 1; $n <= $rowsCnt; $n++)
{
    if($n == $rowsCnt || $n == $rowsCnt-1)
    {
        continue;
    }
    $arRowsWidth_tmp = $arRowsWidth;
    $accumulated = 0;
    foreach ($arColsCaption as $columnId => $column)
    {
        if (is_null($arCells[$n][$columnId]))
        {
            $accumulated += $arRowsWidth_tmp[$columnId];
            $arRowsWidth_tmp[$columnId] = null;
        }
        else
        {
            $arRowsWidth_tmp[$columnId] += $accumulated;
            $accumulated = 0;
        }
    }

    $x0 = $pdf->GetX();
    $y0 = $pdf->GetY();

    $pdf->SetFont($fontFamily, '', $fontSize);

    if (!is_null($arCells[$n]['NAME']))
    {
        $text = $arCells[$n]['NAME'];
        $cellWidth = $arRowsWidth_tmp['NAME'];
    }
    else
    {
        $text = (array_key_exists('VAT_RATE', $arCells[$n])) ? $arCells[$n]['VAT_RATE'] : '';
        $cellWidth = (array_key_exists('VAT_RATE', $arRowsWidth_tmp)) ? $arRowsWidth_tmp['VAT_RATE'] : 0;
    }

    $l = 0;
    do
    {
        $width = ($cellWidth-5 > 0) ? $cellWidth-5 : 0;
        list($string, $text) = $pdf->splitString($text, $width);

        foreach ($arColsCaption as $columnId => $column)
        {
            if (in_array($columnId, array('QUANTITY', 'PRICE', 'SUM')))
            {
                if (!is_null($arCells[$n][$columnId]))
                {
                    $pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'R');
                }
            }
            elseif ($columnId == 'MEASURE')
            {
                if (!is_null($arCells[$n][$columnId]))
                    $pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'C');
            }
            elseif ($columnId == 'NUMBER')
            {
                if (!is_null($arCells[$n][$columnId]))
                    $pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'C');
            }
            elseif ($columnId == 'NAME')
            {
                if (!is_null($arCells[$n][$columnId]))
                    $pdf->Cell($arRowsWidth_tmp[$columnId], 15, $string, 0, 0,  ($n > $cntBasketItem) ? 'R' : '');
            }
            elseif ($columnId == 'VAT_RATE')
            {
                if (!is_null($arCells[$n][$columnId]))
                {
                    if (is_null($arCells[$n][$columnId]))
                        $pdf->Cell($arRowsWidth_tmp[$columnId], 15, $string, 0, 0, 'R');
                    else if ($vat > 0)
                        $pdf->Cell($arRowsWidth_tmp[$columnId], 15, ($l == 0) ? $arCells[$n][$columnId] : '', 0, 0, 'R');
                }
            }

            if ($l == 0)
            {
                $pos = array_search($columnId, $arColumnKeys);
                ${'x'.($pos+1)} = $pdf->GetX();
            }
        }

        $pdf->Ln();
        $l++;
    }
    while($pdf->GetStringWidth($text));

    if ($params['BILL_COLUMN_NAME_SHOW_KIT'] == 'Y')
    {
        if (isset($arProps[$n]) && is_array($arProps[$n]))
        {
            $pdf->SetFont($fontFamily, '', $fontSize - 2);
            foreach ($arProps[$n] as $property)
            {
                $i = 0;
                $line = 0;
                foreach ($arColsCaption as $columnId => $caption)
                {
                    $i++;
                    if ($i == $columnCount)
                        $line = 1;
                    if ($columnId == 'NAME')
                        $pdf->Cell($arRowsWidth_tmp[$columnId], 12, $property, 0, $line);
                    else
                        $pdf->Cell($arRowsWidth_tmp[$columnId], 12, '', 0, $line);
                }
            }
        }
    }

    $y5 = $pdf->GetY();

    if ($y0 > $y5)
        $y0 = $margin['top'];

    for ($i = ($n > $cntBasketItem) ? $columnCount - 1 : 0; $i <= $columnCount; $i++)
    {

        if ($vat > 0 || $arColumnKeys[$i] != 'VAT_RATE')
            $pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
    }

    $pdf->Line(($n <= $cntBasketItem) ? $x0 : ${'x'.($columnCount-1)}, $y5, ${'x'.$columnCount}, $y5);
}
$pdf->Ln();



if ($params['BILL_TOTAL_SHOW_KIT'] == 'Y')
{
    $pdf->SetFont($fontFamily, 'B', $fontSize);
    $pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);
    $pdf->Cell(450, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_ITOGO')),0,0,'R');
    $pdf->Cell(0, 18, CSalePdf::prepareToPdf(end($arCells)['SUM']),0,0,'R');
    $pdf->Ln();
    $pdf->SetFont($fontFamily, '', $fontSize);
    $pdf->Cell(450, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_NDS')),0,0,'R');
	if($taxes)
	{
		$pdf->Cell(
			0,
			18,
			CSalePdf::prepareToPdf(
				number_format(
					($taxesList[0]["VALUE_MONEY"]),
					2,
					'.',
					''
				)),
			0,
			0,
			'R'
		);
	}
	else
	{
		$pdf->Cell(0, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_WITHOUT_NDS')),0,0,'R');
	}
    $pdf->Ln();
}

if ($params['BILL_TOTAL_SHOW_KIT'] == 'Y')
{

    $pdf->SetFont($fontFamily, 'B', $fontSize);
    if (in_array($payment->getField('CURRENCY'), array("RUR", "RUB")))
    {
        $pdf->Ln();
        $pdf->SetFont($fontFamily, 'B', $fontSize);
        $x0 = $pdf->GetX();
        $pdf->Cell(0, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_ALL_TO_PAY').' '.Number2Word_Rus($payment->getField('SUM'))));
        $x1 = $pdf->GetX();
        $pdf->Ln();

        $y0 = $pdf->GetY();
        $pdf->Line($x0, $y0, $x1, $y0);
    }
    else
    {
        $pdf->Write(15, CSalePdf::prepareToPdf(SaleFormatCurrency(
            $payment->getSum(),
            $payment->getField("CURRENCY"),
            false
        )));
    }
    $pdf->Ln();
    $pdf->Ln();
}
if ($params["BILL_COMMENT1_KIT"] || $params["BILL_COMMENT2_KIT"])
{
    $pdf->Write(15, CSalePdf::prepareToPdf(Loc::getMessage('SALE_HPS_BILL_KIT_COND_COMM')));
    $pdf->Ln();

    $pdf->SetFont($fontFamily, '', $fontSize);

    if ($params["BILL_COMMENT1_KIT"])
    {
        $pdf->Write(15, HTMLToTxt(preg_replace(
            array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
            CSalePdf::prepareToPdf($params["BILL_COMMENT1_KIT"])
        ), '', array(), 0));
        $pdf->Ln();
        $pdf->Ln();
    }

    if ($params["BILL_COMMENT2_KIT"])
    {
        $pdf->Write(15, HTMLToTxt(preg_replace(
            array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
            CSalePdf::prepareToPdf($params["BILL_COMMENT2_KIT"])
        ), '', array(), 0));
        $pdf->Ln();
        $pdf->Ln();
    }
}

if(strlen($order->getField('COMMENTS')) > 0)
{
    $pdf->SetFont($fontFamily, '', $fontSize);
    $pdf->Cell(70, 18,CSalePdf::prepareToPdf($order->getField('COMMENTS')));
    $pdf->Ln();
    $pdf->Ln();
}

$pdf->Ln();
$pdf->Ln();

if ($params['BILL_SIGN_SHOW_KIT'] == 'Y')
{
    if ($params['BILL_PATH_TO_STAMP_KIT'])
    {
        $filePath = $pdf->GetImagePath($params['BILL_PATH_TO_STAMP_KIT']);

        if ($filePath != '' && !$blank && \Bitrix\Main\IO\File::isFileExists($filePath))
        {
            list($stampHeight, $stampWidth) = $pdf->GetImageSize($params['BILL_PATH_TO_STAMP_KIT']);
            if ($stampHeight && $stampWidth)
            {
                if ($stampHeight > 120 || $stampWidth > 120)
                {
                    $ratio = 120 / max($stampHeight, $stampWidth);
                    $stampHeight = $ratio * $stampHeight;
                    $stampWidth = $ratio * $stampWidth;
                }

                if ($pdf->GetY() + $stampHeight > $pageHeight)
                    $pdf->AddPage();

                $pdf->Image(
                    $params['BILL_PATH_TO_STAMP_KIT'],
                    $margin['left'] + 40, $pdf->GetY(),
                    $stampWidth, $stampHeight
                );
            }
        }
    }

    $pdf->SetFont($fontFamily, 'B', $fontSize);

    if ($params["SELLER_COMPANY_DIRECTOR_POSITION_KIT"])
    {
        $isDirSign = false;
        if (!$blank && $params['SELLER_COMPANY_DIR_SIGN_KIT'])
        {
            list($signHeight, $signWidth) = $pdf->GetImageSize($params['SELLER_COMPANY_DIR_SIGN_KIT']);

            if ($signHeight && $signWidth)
            {
                $ratio = min(37.5/$signHeight, 150/$signWidth);
                $signHeight = $ratio * $signHeight;
                $signWidth  = $ratio * $signWidth;

                $isDirSign = true;
            }
        }



        $pdf->Cell(90, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_BOTTOM_SALLER')));
        $x1 = $pdf->GetX();
        $pdf->Cell(180, 18, CSalePdf::prepareToPdf($params["SELLER_COMPANY_DIRECTOR_POSITION_KIT"]),0,0,'C');
        $x2 = $pdf->GetX();
        $pdf->Cell(150, 18, '');

        if ($params['SELLER_COMPANY_DIR_SIGN_KIT'])
        {
            list($signHeight, $signWidth) = $pdf->GetImageSize($params['SELLER_COMPANY_DIR_SIGN_KIT']);

            if ($signHeight && $signWidth)
            {
                $ratio = min(37.5/$signHeight, 150/$signWidth);
                $signHeight = $ratio * $signHeight;
                $signWidth  = $ratio * $signWidth;

                $isAccSign = true;
            }
            if ($isAccSign)
            {
                $pdf->Image(
                    $params['SELLER_COMPANY_DIR_SIGN_KIT'],
                    $x2 + 80 - $signWidth/2, $pdf->GetY() - $signHeight + 25,
                    $signWidth, $signHeight
                );
            }
        }
        $x3 = $pdf->GetX();
        $pdf->Cell(0, 18, CSalePdf::prepareToPdf($params["SELLER_COMPANY_DIRECTOR_NAME_KIT"]),0,0,'C');
        $x4 = $pdf->GetX();
        $pdf->Ln();
        $pdf->SetFont($fontFamily, 'B', $fontSize-3);
        $y0 = $pdf->GetY();
        $pdf->Cell(90, 18, '');
        $pdf->Cell(180, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_DOLGNOST')),0,0,'C');
        $pdf->Cell(150, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_BOTTOM_PODPIS')),0,0,'C');
        $pdf->Cell(0, 18, CSalePdf::prepareToPdf(Loc::getMessage('SALE_BOTTOM_SHIFR_PODPIS')),0,0,'C');
        $pdf->Line($x1, $y0, $x2, $y0);
        $pdf->Line($x2+15, $y0, $x3-15, $y0);
        $pdf->Line($x3, $y0, $x4, $y0);
    }


}

if ($params["SELLER_COMPANY_ACCOUNTANT_POSITION_KIT"])
{
	$pdf->SetFont($fontFamily, 'B', $fontSize);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(120, 18, CSalePdf::prepareToPdf($params["SELLER_COMPANY_ACCOUNTANT_POSITION_KIT"]));
	$y0 = $pdf->GetY();
	$x1 = $pdf->GetX();
	$pdf->Line($x1, $y0+14, $x2, $y0+14);
	if (!$blank && $params["SELLER_COMPANY_ACC_SIGN_KIT"])
	{
		list($signHeight, $signWidth) = $pdf->GetImageSize($params["SELLER_COMPANY_ACC_SIGN_KIT"]);

		if ($signHeight && $signWidth)
		{
			$ratio = min(37.5/$signHeight, 150/$signWidth);
			$signHeight = $ratio * $signHeight;
			$signWidth  = $ratio * $signWidth;

			$isDirSign = true;
		}
		$pdf->Image(
			$params["SELLER_COMPANY_ACC_SIGN_KIT"],
			$x2 - $signWidth/2-70, $pdf->GetY() - $signHeight+13,
			$signWidth, $signHeight
		);
	}
}

$name = \Bitrix\Main\Config\Option::get('kit.bill','FILE_NAME','N#ORDER_ID# from #DATE#');
if(!$name)
{
	$name = 'N#ORDER_ID# from #DATE#';
}
$number = str_replace('/', chr(2), $params['NUMBER']);
$name = str_replace(array('#ORDER_ID#','#NUMBER#','#DATE#'),array($order->getId(),$number, ConvertDateTime($params['PAYMENT_DATE_INSERT'], 'DD-MM-YYYY')),$name);
$name.='.pdf';

$dest = 'I';
if ($_REQUEST['GET_CONTENT'] == 'Y')
    $dest = 'S';
else if ($_REQUEST['DOWNLOAD'] == 'Y')
    $dest = 'D';

return $pdf->Output($name, $dest);
?>