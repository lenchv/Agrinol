<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*TAGS*/
if ($arParams["SEARCH_PAGE"])
{
	if ($arResult["FIELDS"] && isset($arResult["FIELDS"]["TAGS"]))
	{
		$tags = array();
		foreach (explode(",", $arResult["FIELDS"]["TAGS"]) as $tag)
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
		$arResult["FIELDS"]["TAGS"] = implode(", ", $tags);
	}
}


//Из инфоблока подтягиваем ИД пользовательского поля с баллами и ИД группы, к которой принадлежат участники акции
$pointsID = (($arResult["PROPERTIES"]["point_property"]["VALUE"] == "")? $arResult["PROPERTIES"]["point_property"]["~DEFAULT_VALUE"] : $arResult["PROPERTIES"]["point_property"]["~VALUE"]);
$groupID = intval($arResult["PROPERTIES"]["group"]["VALUE"]);
$lastDatePurchase = "UF_DATE_LAST_BUY"; //Свойство последней осуществленной покупки пользователем
$arFilter = array("GROUPS_ID" => array($groupID), "ACTIVE" => "Y");
$arParamsForDb = array(
	"SELECT" => array($pointsID),
	"FIELDS" => array("ID","NAME", "LAST_NAME", "SECOND_NAME", "PERSONAL_CITY", "WORK_CITY")
);
$order = "sort"; //игнорируется методом но обязан быть
$rsUsers = CUser::GetList(($by=array($pointsID => "desc", $lastDatePurchase => "desc")), $order, $arFilter, $arParamsForDb);
$rsUsers->NavStart(intval($arParams["COUNT_USERS_ON_PAGE_RARUS"]));
$arResult["NAV_STRING_USERS"] = $rsUsers->GetPageNavStringEx(
	$navComponentObject,
	$arParams["PAGER_TITLE"],
	"round",
	$arParams["PAGER_SHOW_ALWAYS"],
	$this->__component
);
$arResult["RATING_USERS"] = array();
$userID = ($USER->IsAuthorized())? $USER->GetID() : -1;  //Если пользователь авторизован, то сохраняем его ИД
$i = ($rsUsers->NavPageNomer-1)*$rsUsers->NavPageSize + 1;					//Номер пользователя в списке
while ($arUser = $rsUsers->GetNext()) {
	$user["NAME"] = $arUser["LAST_NAME"]." ".$arUser["NAME"]." ".$arUser["SECOND_NAME"];
	$user["CITY"] = ($arUser["PERSONAL_CITY"] == '')?  $arUser["WORK_CITY"] : $arUser["PERSONAL_CITY"];
	$user["POINTS"] = intval($arUser[$pointsID]);
	$user["NUMBER"] = $i++;
	$user["ID"] = $arUser["ID"];
	if ($userID == $user["ID"])
	{
		$user["CURRENT"] = true;
	} 
	else 
	{
		$user["CURRENT"] = false;
	}
	$arResult["RATING_USERS"][] = $user;
}
unset($rsUser);

$dateActiveFrom = $arResult["DATE_ACTIVE_FROM"];
$dateActiveTo = $arResult["DATE_ACTIVE_TO"];
$dateCurrent = new \Bitrix\Main\Type\DateTime;
if ($DB->CompareDates($dateActiveTo,$dateCurrent) >= 0)
{
	$arResult["ACTIVE_ON_DATE"] = true;
} 
else 
{
	$arResult["ACTIVE_ON_DATE"] = false;
}

$arResult["DISPLAY_ACTIVE_FROM"] = ConvertDateTime($dateActiveFrom, "DD.MM.YYYY", "ru");
$arResult["DISPLAY_ACTIVE_TO"] = ConvertDateTime($dateActiveTo, "DD.MM.YYYY", "ru");