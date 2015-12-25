<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?php
/*
$str = $_SERVER["REQUEST_URI"];
if(preg_match('@[A-Z]@u',$str))
{
	Header('HTTP/1.1 301 Moved Permanently');
	Header('Location: '.strtolower($str));
}*/
?>



<?
/* IncludeTemplateLangFile(__FILE__); */
$APPLICATION->SetPageProperty("robots", "index,follow");

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/scripts.js');

?><!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=<?= LANG_CHARSET?>" />

	<!-- заголовок -->
	<title><?$APPLICATION->ShowTitle();?></title>

	<!-- метатеги и подключаемые файлы -->
	<?$APPLICATION->ShowHead();?>
	<script src="/scripts/new_script.js"></script>
	<link href="/scripts/custom.css" type="text/css"  rel="stylesheet" />
</head>

<body>
	<?$APPLICATION->ShowPanel();?>
	<div class="container-fw">
		<div id="header">
			<a id="logo" href="/"></a>
			<!--<div id="basket">
				<ul>
					<li data-title="Товаров">2</li>
					<li data-title="Сумма">10 000 грн</li>
				</ul>
			</div>-->
			<?$APPLICATION->IncludeComponent(
				"bitrix:sale.basket.basket.line",
				"agrinol",
				Array(
					"PATH_TO_BASKET" => "/personal/cart/",
					"PATH_TO_PERSONAL" => "/personal/",
					"SHOW_PERSONAL_LINK" => "N",
					"SHOW_NUM_PRODUCTS" => "Y",
					"SHOW_TOTAL_PRICE" => "Y",
					"EMBED_MINICART" => "N",
					"POSITION_FIXED" => "N",
					"SHOW_PRODUCTS" => "N",
					"POSITION_TOP" => "Y",
					"POSITION_RIGHT" => "Y",
					"POSITION_HEIGHT" => "N",
					"DISPLAY_COLLAPSE" => "Y",
					"PATH_TO_ORDER" => SITE_DIR."personal/order/",
					"SHOW_DELAY" => "Y",
					"SHOW_NOTAVAIL" => "Y",
					"SHOW_SUBSCRIBE" => "Y",
					"SHOW_IMAGE" => "Y",
					"SHOW_PRICE" => "Y",
					"SHOW_SUMMARY" => "Y"
				)
			);?>
			<?$APPLICATION->IncludeComponent(
				"just_develop:buy.more",
				"",
				Array(
					"JD_BUY_MORE_ID" => array("1"),
					"JD_BIND_ID" => "bx_cart_block",
					"JD_BUY_MORE_MSG" => "Купите ещё товара на сумму #SUM# и получите #BONUS#",
					"JD_PROCENT" => "0",
					"JD_NOT_LOAD" => "N",
					"AUTO_HIDE_CLICK" => "N",
					"AUTO_HIDE" => "Y",
					"OFFSET_TOP" => "0",
					"OFFSET_LEFT" => "-50",
					"POS_ANGLE" => "top",
					"OFFSET_ANGLE" => "100",
					"DETAIL_URL" => "",
					"ACTION_ADD" => "",
					"HIDE_TIMER" => "20"
				)
			);?>
			<div class="top-panel">
				<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		)
	),
	false
);?>
				<!-- форма авторизации -->
				<?/*$APPLICATION->IncludeComponent(
					"bitrix:system.auth.form", 
					"auth", 
					Array(
						"REGISTER_URL" => "/auth/",
						"FORGOT_PASSWORD_URL" => "",
						"PROFILE_URL" => "/personal/profile/",
						"SHOW_ERRORS" => "Y"
					),
					false
				);*/?>
				<?$APPLICATION->IncludeComponent(
					"bxmod:auth.dialog",
					"",
					Array(
						"SUCCESS_RELOAD_TIME" => "0"
					),
					false
				);?>
			</div>
			<div class="panel">
				<div class="callback">
					<span>+38 (066) 334-34-34</span>
					<!--<button class="popup-modal form-feedback" id="popup_main_feedback">Заказ обратного звонка</button>-->
					<?$APPLICATION->IncludeComponent(
	"wsm:callbackpro", 
	"window1", 
	array(
		"FORM_NAME" => "Заказать обратный звонок",
		"LINK_TEXT" => "Заказать обратный звонок",
		"FLOAT_RIGHT" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"FIELD_NAME_TITLE" => "",
		"FIELD_PHONE_TITLE" => "",
		"FIELD_THEME_TITLE" => "",
		"FIELD_TIME_TITLE" => "",
		"FIELD_NAME_HINT" => "",
		"FIELD_PHONE_HINT" => "",
		"FIELD_THEME_HINT" => "",
		"FIELD_TIME_HINT" => "",
		"INCLUDE_JQUERY" => "Y",
		"INCLUDE_JQUERY_UI" => "Y"
	),
	false
);?>
				</div>
				<!--<div class="search-inline">
					<input type="button" value="" />
					<input type="text" value="" placeholder="Поиск по сайту" />
				</div>-->
				<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"bitronic", 
	array(
		"PRICE_CODE" => array(
		),
		"SEARCH_IN_TREE" => "Y",
		"PAGE" => "#SITE_DIR#search/",
		"PAGE_2" => "#SITE_DIR#search/",
		"COLOR_SCHEME" => "metal",
		"CURRENCY" => "UAH",
		"CACHE_TIME" => "86400",
		"INCLUDE_JQUERY" => "N",
		"PHOTO_SIZE" => "10",
		"EXAMPLE_ENABLE" => "N",
		"EXAMPLES" => array(
			0 => "TAXI",
			1 => "SAE",
			2 => "",
		),
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "12",
		"ORDER" => "rank",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "Y",
		"SHOW_OTHERS" => "N",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "all",
		),
		"CATEGORY_0_iblock_products" => array(
			0 => "all",
		)
	),
	false
);?>
				<?/*$APPLICATION->IncludeComponent(
					"bitrix:search.title",
					"catalog",
					Array(
						"SHOW_INPUT" => "Y",
						"INPUT_ID" => "title-search-input",
						"CONTAINER_ID" => "title-search",
						"PRICE_CODE" => array(),
						"PRICE_VAT_INCLUDE" => "Y",
						"PREVIEW_TRUNCATE_LEN" => "",
						"SHOW_PREVIEW" => "Y",
						"PREVIEW_WIDTH" => "75",
						"PREVIEW_HEIGHT" => "75",
						"CONVERT_CURRENCY" => "N",
						"PAGE" => "#SITE_DIR#search/index.php",
						"NUM_CATEGORIES" => "1",
						"TOP_COUNT" => "20",
						"ORDER" => "rank",
						"USE_LANGUAGE_GUESS" => "Y",
						"CHECK_DATES" => "N",
						"SHOW_OTHERS" => "N",
						"CATEGORY_0_TITLE" => "Каталог",
						"CATEGORY_0" => array("iblock_catalog"),
						"CATEGORY_0_iblock_catalog" => array("all")
					)
				);*/?>
				<!--<div class="user-city-detector">
					<span class="form-input select">
						<select>
							<option>Донецк</option>
							<option>Донецк</option>
							<option>Донецк</option>
						</select>
					</span>
				</div>-->
				<?$APPLICATION->IncludeComponent(
					"twofingers:location",
					"",
					Array(
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "3600",
						"SET_TITLE" => "N"
					),
					false
				);?> 
			</div>
		</div>
	</div>
	<?if (defined('IS_HOMEPAGE')):?>
		<div class="inform-line">
			<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
			        "AREA_FILE_SHOW" => "file", 
			        "PATH" => SITE_TEMPLATE_PATH."/include_areas/inform-panel.php"
			    )
			);?>
		</div>
	<?endif?>
	<div id="subheader">
		<div class="container-fw">
			<?
				if (defined('IS_HOMEPAGE') /*CPageOption::GetOptionInt('main', 'IS_HOMEPAGE', 0) > 0*/ ) 
				{
					$APPLICATION->IncludeComponent(
						"artingen:bxslider", 
						".default", 
						array(
							"IBLOCK_TYPE" => "sliders",
							"IBLOCK_ID" => "29",
							"URL_PROP_CODE" => "URL",
							"SLIDER_MODE" => "fade",
							"SLIDER_WIDTH" => "0",
							"SLIDER_SPEED" => "1000",
							"SLIDER_INFINITE_LOOP" => "Y",
							"SLIDER_HIDECONTROLONEND" => "N",
							"SLIDER_AUTO" => "Y",
							"SLIDER_AUTO_CONTROLS" => "N",
							"SLIDER_CAPTIONS" => "N",
							"SLIDER_RESPONSIVE" => "Y",
							"INCLUDE_JQUERY" => "N",
							"CACHE_TYPE" => "N",
							"CACHE_TIME" => "3600"
						),
						false
					);
				}
				else
				{
					$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	".default", 
	array(
		"START_FROM" => "2",
		"PATH" => "",
		"SITE_ID" => "-"
	),
	false
);
				}
			?>
		</div>
	</div>
	<div class="container-fw">
		<div id="left-menu">
			<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"static-tree", 
	array(
		"ROOT_MENU_TYPE" => "shop-left",
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		)
	),
	false
);?>
		</div>
		<div id="content">
			