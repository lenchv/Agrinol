<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/**
*	$arItem["ACTIVE_ON_DATE"] - статус активности акции по дате
*/
/*TAGS*/
if ($arParams["SEARCH_PAGE"])
{
	foreach ($arResult["ITEMS"] as &$arItem)
	{
		if ($arItem["FIELDS"] && isset($arItem["FIELDS"]["TAGS"]))
		{
			$tags = array();
			foreach (explode(",", $arItem["FIELDS"]["TAGS"]) as $tag)
			{
				$tag = trim($tag, " \t\n\r");
				if ($tag)
				{
					$url = CHTTP::urlAddParams(
						$arParams["SEARCH_PAGE"],
						array(
							"tags" => $tag,
						),
						array(
							"encode" => true,
						)
					);
					$tags[] = '<a href="'.$url.'">'.$tag.'</a>';
				}
			}
			$arItem["FIELDS"]["TAGS"] = implode(", ", $tags);
		}
	}
	unset($arItem);
}

$arResult["NAV_STRING"] = $arResult["NAV_RESULT"]->GetPageNavStringEx(
	$navComponentObject,
	$arParams["PAGER_TITLE"],
	$arParams["PAGER_TEMPLATE"],
	$arParams["PAGER_SHOW_ALWAYS"],
	$this->__component,
	$arResult["NAV_PARAM"]
);
foreach ($arResult["ITEMS"] as &$arItem)
{
	$dateActiveFrom = $arItem["DATE_ACTIVE_FROM"];
	$dateActiveTo = $arItem["DATE_ACTIVE_TO"];
	$dateCurrent = new \Bitrix\Main\Type\DateTime;
	if ($DB->CompareDates($dateActiveTo,$dateCurrent) >= 0)
	{
		$arItem["ACTIVE_ON_DATE"] = true;
	} 
	else 
	{
		$arItem["ACTIVE_ON_DATE"] = false;
	}

	$arItem["DISPLAY_ACTIVE_FROM"] = ConvertDateTime($dateActiveFrom, "DD.MM.YYYY", "ru");
	$arItem["DISPLAY_ACTIVE_TO"] = ConvertDateTime($dateActiveTo, "DD.MM.YYYY", "ru");
}
