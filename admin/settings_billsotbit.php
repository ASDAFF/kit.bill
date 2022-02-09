<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php');
$module_id = "kit.bill";

CModule::IncludeModule($module_id);


$arTabs = array();
IncludeModuleLangFile(__FILE__);


$APPLICATION->SetTitle(GetMessage('BILLKIT_SETTING_TITLE'));

$CONS_RIGHT = $APPLICATION->GetGroupRight($module_id);
if ($CONS_RIGHT <= "D") {
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$module_id."/include.php");

function OptionGetValue($key) {
    $result = COption::GetOptionString("kit.bill",$key);
    if($_REQUEST[$key]){
        $result = $_REQUEST[$key];
    }
    return $result;
}

$rsET = CEventType::GetList();
$events = array();
while ($arET = $rsET->Fetch())
{
    $events['REFERENCE_ID'][] = $arET['EVENT_NAME'];
    $events['REFERENCE'][] = $arET['EVENT_NAME'];
}

$arTabs = array(
    array(
        'DIV' => 'edit1',
        'TAB' => GetMessage($module_id.'_edit1'),
        'ICON' => '',
        'TITLE' => GetMessage($module_id.'_edit1'),
        'SORT' => '10'
    )
);

$arGroups = array(
    'OPTION_5' => array('TITLE' => GetMessage($module_id.'_OPTION_5'), 'TAB' => 0),
);

$arOptions['EVENTS'] = array(
    'GROUP' => 'OPTION_5',
    'TITLE' =>  GetMessage($module_id.'_EVENTS_TITLE'),
    'TYPE' => 'MSELECT',
    'DEFAULT' => '',
    'VALUES' => $events,
    'SORT' => '60',
    'REFRESH' => 'N',
    'NOTES'=> GetMessage($module_id.'_EVENTS_DESC')
);
$arOptions['FILE_NAME'] = array(
    'GROUP' => 'OPTION_5',
    'TITLE' =>  GetMessage($module_id.'_FILE_NAME_TITLE'),
    'TYPE' => 'STRING',
    'DEFAULT' => '',
    'SORT' => '80',
    'REFRESH' => 'N',
    'NOTES'=> GetMessage($module_id.'_FILE_NAME_DESC')
);

?>
    <a name="form"></a>



<?
$RIGHT = $APPLICATION->GetGroupRight($module_id);
if($RIGHT != "D") {


    if($RIGHT >= "W") {
        $showRightsTab = true;
    }

    $opt = new CModuleOptions($module_id, $arTabs, $arGroups, $arOptions, $showRightsTab);
    $opt->ShowHTML();
}


$tabControl = new CAdminTabControl("tabControl", $arTabs);
CJSCore::Init(array("jquery"));
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>