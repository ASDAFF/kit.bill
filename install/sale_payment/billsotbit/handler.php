<?php

namespace Sale\Handlers\PaySystem;

\CModule::includeModule('kit.bill');
if(!class_exists('BillHandler')) return false;
class BillKitHandler extends \BillHandler
{

    /**
     * @return array
     */
    public function getCurrencyList()
    {
        return array('RUB');
    }

    /**
     * @return bool
     */
    public function isAffordPdf()
    {
        return true;
    }


}