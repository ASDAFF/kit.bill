<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) 
	die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$data = array(
	'NAME' => Loc::getMessage('SALE_HPS_BILL_KIT_TITLE'),
	'SORT' => 100,
	'CODES' => array(
		"PAYMENT_DATE_INSERT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_DATE"),
			"SORT" => 100,
			'GROUP' => 'PAYMENT',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_DATE_DESC"),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "DATE_BILL_DATE",
				"PROVIDER_KEY" => "PAYMENT"
			)
		),
		"BILL_ORDER_SUBJECT_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ORDER_SUBJECT"),
			'GROUP' => 'HEADER_SETTINGS',
			"SORT" => 200
		),
			"BILL_ORDER_HEADER_TITLE_KIT" => array(
					"NAME" => Loc::getMessage("BILL_ORDER_HEADER_TITLE_KIT"),
					'GROUP' => 'HEADER_SETTINGS',
					"SORT" => 220
			),
		"PAYMENT_DATE_PAY_BEFORE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_PAY_BEFORE"),
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_PAY_BEFORE_DESC"),
			"SORT" => 300,
			'GROUP' => 'PAYMENT',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "DATE_PAY_BEFORE",
				"PROVIDER_KEY" => "ORDER"
			)
		),
		"SELLER_COMPANY_NAME_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_SUPPLI"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_SUPPLI_DESC"),
			"SORT" => 400
		),
		"SELLER_COMPANY_ADDRESS_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ADRESS_SUPPLI"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_ADRESS_SUPPLI_DESC"),
			"SORT" => 500
		),
		"SELLER_COMPANY_PHONE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_PHONE_SUPPLI"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_PHONE_SUPPLI_DESC"),
			"SORT" => 600
		),
		"SELLER_COMPANY_INN_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_INN_SUPPLI"),
			"SHORT_NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_INN_SUPPLI_SHORT"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_INN_SUPPLI_DESC"),
			"SORT" => 700
		),
		"SELLER_COMPANY_KPP_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_KPP_SUPPLI"),
			"SHORT_NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_KPP_SUPPLI_SHORT"),
			'GROUP' => 'SELLER_COMPANY',
			"SORT" => 800,
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_KPP_SUPPLI_DESC")
		),
		"SELLER_COMPANY_BANK_ACCOUNT_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ORDER_SUPPLI"),
			"SHORT_NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ORDER_SUPPLI_SHORT"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_ORDER_SUPPLI_DESC"),
			"SORT" => 900,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_ORDER_SUPPLI_VAL"),
				"PROVIDER_KEY" => ""
			)
		),
		"SELLER_COMPANY_BANK_NAME_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BANK_SUPPLI"),
			"SHORT_NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BANK_SUPPLI_SHORT"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_BANK_SUPPLI_DESC"),
			"SORT" => 1000,
		),
		"SELLER_COMPANY_BANK_CITY_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BCITY_SUPPLI"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_BCITY_SUPPLI_DESC"),
			"SORT" => 1100
		),
		"SELLER_COMPANY_BANK_ACCOUNT_CORR_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_KORORDER_SUPPLI"),
			"SHORT_NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_KORORDER_SUPPLI_SHORT"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_KORORDER_SUPPLI_DESC"),
			"SORT" => 1200
		),
		"SELLER_COMPANY_BANK_BIC_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BIK_SUPPLI"),
			"SHORT_NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BIK_SUPPLI_SHORT"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_BIK_SUPPLI_DESC"),
			"SORT" => 1300
		),
			"SELLER_COMPANY_EMAIL_KIT" => array(
					"NAME" => Loc::getMessage("SELLER_COMPANY_EMAIL_KIT"),
					"SHORT_NAME" => Loc::getMessage("SELLER_COMPANY_EMAIL_KIT_SHORT"),
					'GROUP' => 'SELLER_COMPANY',
					"DESCRIPTION" => Loc::getMessage("SELLER_COMPANY_EMAIL_KIT_DESC"),
					"SORT" => 1320
			),
			"SELLER_COMPANY_SITE_KIT" => array(
					"NAME" => Loc::getMessage("SELLER_COMPANY_SITE_KIT"),
					"SHORT_NAME" => Loc::getMessage("SELLER_COMPANY_SITE_KIT_SHORT"),
					'GROUP' => 'SELLER_COMPANY',
					"DESCRIPTION" => Loc::getMessage("SELLER_COMPANY_SITE_KIT_DESC"),
					"SORT" => 1330
			),
		"SELLER_COMPANY_DIRECTOR_POSITION_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_POS_SUPPLI"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_POS_SUPPLI_DESC"),
			"SORT" => 1400,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_POS_SUPPLI_VAL"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"SELLER_COMPANY_ACCOUNTANT_POSITION_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_POS_SUPPLI"),
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_POS_SUPPLI_DESC"),
			'GROUP' => 'SELLER_COMPANY',
			"SORT" => 1500,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_POS_SUPPLI_VAL"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"SELLER_COMPANY_DIRECTOR_NAME_KIT" => array(
			'GROUP' => 'SELLER_COMPANY',
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_SUPPLI"),
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_SUPPLI_DESC"),
			"SORT" => 1600
		),
		"SELLER_COMPANY_ACCOUNTANT_NAME_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_SUPPLI"),
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_SUPPLI_DESC"),
			"SORT" => 1700
		),
		"BUYER_PERSON_COMPANY_NAME_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER"),
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_DESC"),
			"SORT" => 1800,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "COMPANY_NAME",
				"PROVIDER_KEY" => "PROPERTY"
			)
		),
			"BUYER_PERSON_COMPANY_LAST_NAME_KIT" => array(
					"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_LAST_NAME"),
					'GROUP' => 'BUYER_PERSON_COMPANY',
					"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_LAST_NAME_DESC"),
					"SORT" => 1800,
					'DEFAULT' => array(
							"PROVIDER_VALUE" => "LAST_NAME",
							"PROVIDER_KEY" => "PROPERTY"
					)
			),
		"BUYER_PERSON_COMPANY_INN_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_INN"),
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_INN_DESC"),
			"SORT" => 1900,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "INN",
				"PROVIDER_KEY" => "PROPERTY"
			)
		),
			"BUYER_PERSON_COMPANY_KPP_KIT" => array(
					"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_KPP"),
					'GROUP' => 'BUYER_PERSON_COMPANY',
					"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_KPP_DESC"),
					"SORT" => 1900,
					'DEFAULT' => array(
							"PROVIDER_VALUE" => "KPP",
							"PROVIDER_KEY" => "PROPERTY"
					)
			),
			"BUYER_PERSON_COMPANY_OGRN_KIT" => array(
					"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_OGRN"),
					'GROUP' => 'BUYER_PERSON_COMPANY',
					"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_OGRN_DESC"),
					"SORT" => 1900,
					'DEFAULT' => array(
							"PROVIDER_VALUE" => "OGRN",
							"PROVIDER_KEY" => "PROPERTY"
					)
			),
		"BUYER_PERSON_COMPANY_ADDRESS_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_ADRES"),
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_ADRES_DESC"),
			"SORT" => 200,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "ADDRESS",
				"PROVIDER_KEY" => "PROPERTY"
			)
		),
		"BUYER_PERSON_COMPANY_PHONE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_PHONE"),
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_PHONE_DESC"),
			"SORT" => 2100,
			"PROVIDER_VALUE" => "PHONE",
			"PROVIDER_KEY" => "PROPERTY"
		),
		"BUYER_PERSON_COMPANY_FAX_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_FAX"),
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_FAX_DESC"),
			"SORT" => 2200,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "FAX",
				"PROVIDER_KEY" => "PROPERTY"
			)
		),
		"BUYER_PERSON_COMPANY_NAME_CONTACT_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_PERSON"),
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_CUSTOMER_PERSON_DESC"),
			"SORT" => 2300,
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "PAYER_NAME",
				"PROVIDER_KEY" => "PROPERTY"
			)
		),
		"BILL_COMMENT1_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COMMENT1"),
			"SORT" => 2400,
			'GROUP' => 'FOOTER_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_COMMENT1_VALUE"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COMMENT2_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COMMENT2"),
			"SORT" => 2500,
			'GROUP' => 'FOOTER_SETTINGS',
		),
		"BILL_PATH_TO_LOGO_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO"),
			"SORT" => 2600,
			'GROUP' => 'VISUAL_SETTINGS',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DESC"),
			'INPUT' => array(
				'TYPE' => 'FILE'
			)
		),
		"BILL_LOGO_DPI_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DPI"),
			"SORT" => 2700,
			'GROUP' => 'VISUAL_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'ENUM',
				'OPTIONS' => array(
					'96' => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DPI_96"),
					'600' => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DPI_600"),
					'300' => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DPI_300"),
					'150' => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DPI_150"),
					'72' => Loc::getMessage("SALE_HPS_BILL_KIT_LOGO_DPI_72")
				)
			),
		),
		"BILL_PATH_TO_STAMP_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_PRINT"),
			"SORT" => 2800,
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_PRINT_DESC"),
			'INPUT' => array(
				'TYPE' => 'FILE'
			)
		),
		"SELLER_COMPANY_DIR_SIGN_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_SIGN_SUPPLI"),
			"SORT" => 2900,
			'GROUP' => 'SELLER_COMPANY',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_DIR_SIGN_SUPPLI_DESC"),
			'INPUT' => array(
				'TYPE' => 'FILE'
			)
		),
		"SELLER_COMPANY_ACC_SIGN_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_SIGN_SUPPLI"),
			"SORT" => 3000,
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_ACC_SIGN_SUPPLI_DESC"),
			'GROUP' => 'SELLER_COMPANY',
			'INPUT' => array(
				'TYPE' => 'FILE'
			)
		),
		"BILL_BACKGROUND_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BACKGROUND"),
			"SORT" => 3100,
			'GROUP' => 'VISUAL_SETTINGS',
			"DESCRIPTION" => Loc::getMessage("SALE_HPS_BILL_KIT_BACKGROUND_DESC"),
			'INPUT' => array(
				'TYPE' => 'FILE'
			)
		),
		"BILL_BACKGROUND_STYLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_BACKGROUND_STYLE"),
			"SORT" => 3200,
			'GROUP' => 'VISUAL_SETTINGS',
			'TYPE' => 'SELECT',
			"INPUT" => array(
				'TYPE' => 'ENUM',
				'OPTIONS' => array(
					'none' => Loc::getMessage("SALE_HPS_BILL_KIT_BACKGROUND_STYLE_NONE"),
					'tile' => Loc::getMessage("SALE_HPS_BILL_KIT_BACKGROUND_STYLE_TILE"),
					'stretch' => Loc::getMessage("SALE_HPS_BILL_KIT_BACKGROUND_STYLE_STRETCH")
				)
			),
		),
		"BILL_MARGIN_TOP_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_MARGIN_TOP"),
			"SORT" => 3300,
			'GROUP' => 'VISUAL_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "15",
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_MARGIN_RIGHT_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_MARGIN_RIGHT"),
			"SORT" => 3400,
			'GROUP' => 'VISUAL_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "15",
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_MARGIN_BOTTOM_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_MARGIN_BOTTOM"),
			"SORT" => 3500,
			'GROUP' => 'VISUAL_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "15",
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_MARGIN_LEFT_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_MARGIN_LEFT"),
			"SORT" => 3600,
			'GROUP' => 'VISUAL_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "20",
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_HEADER_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_HEADER_SHOW"),
			'SORT' => 3700,
			'GROUP' => 'HEADER_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_PAYER_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_PAYER_SHOW"),
			'SORT' => 3800,
			'GROUP' => 'BUYER_PERSON_COMPANY',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_SIGN_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_SIGN_SHOW"),
			'SORT' => 3900,
			'GROUP' => 'FOOTER_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_TOTAL_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_TOTAL_SHOW"),
			'SORT' => 4000,
			'GROUP' => 'FOOTER_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_NUMBER_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_NUMBER_SHOW"),
			'SORT' => 4100,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_NUMBER_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_NUMBER_TITLE"),
			'SORT' => 4200,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_NUMBER_VALUE"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COLUMN_NAME_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_NAME_SHOW"),
			'SORT' => 4300,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_NAME_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_NAME_TITLE"),
			'SORT' => 4400,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_NAME_VALUE"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COLUMN_QUANTITY_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_QUANTITY_SHOW"),
			'SORT' => 4500,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_QUANTITY_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_QUANTITY_TITLE"),
			'SORT' => 4600,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_QUANTITY_VALUE"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COLUMN_MEASURE_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_MEASURE_SHOW"),
			'SORT' => 4700,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_MEASURE_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_MEASURE_SHOW"),
			'SORT' => 4800,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage('SALE_HPS_BILL_KIT_COLUMN_MEASURE_VALUE'),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COLUMN_PRICE_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_PRICE_SHOW"),
			'SORT' => 4900,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_PRICE_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_PRICE_TITLE"),
			'SORT' => 5000,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_PRICE_VALUE"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COLUMN_SUM_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_SUM_SHOW"),
			'SORT' => 5100,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_SUM_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_SUM_TITLE"),
			'SORT' => 5200,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_SUM_VALUE"),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_COLUMN_VAT_RATE_SHOW_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_VAT_RATE_SHOW"),
			'SORT' => 5300,
			'GROUP' => 'COLUMN_SETTINGS',
			"INPUT" => array(
				'TYPE' => 'Y/N'
			),
			'DEFAULT' => array(
				"PROVIDER_VALUE" => "Y",
				"PROVIDER_KEY" => "INPUT"
			)
		),
		"BILL_COLUMN_VAT_RATE_TITLE_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_COLUMN_VAT_RATE_TITLE"),
			'SORT' => 5400,
			'GROUP' => 'COLUMN_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage('SALE_HPS_BILL_KIT_COLUMN_VAT_RATE_VALUE'),
				"PROVIDER_KEY" => "VALUE"
			)
		),
		"BILL_HEADER_KIT" => array(
			"NAME" => Loc::getMessage("SALE_HPS_BILL_KIT_HEADER"),
			'SORT' => 5500,
			'GROUP' => 'HEADER_SETTINGS',
			'DEFAULT' => array(
				"PROVIDER_VALUE" => Loc::getMessage('SALE_HPS_BILL_KIT_HEADER_VALUE'),
				"PROVIDER_KEY" => "VALUE"
			)
		),
	)
);
?>