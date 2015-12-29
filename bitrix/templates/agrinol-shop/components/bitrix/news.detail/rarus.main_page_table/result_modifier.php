<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/**
*	!!!НЕ ВКЛЮЧАТЬ КЭШИРОВАНИЕ!!!
*	$arResult["RATING_USERs"] - Получем 3х лидеров акции, если пользователь авторизован, то и его дописываем с пометкой arResult["RATING_USERS"]
*	$arResult["GIFT"] - пути к изображениям подарков
*	$arResult["TO_END"] = Array(
*		["DAYS_LEFT"]	- дней осталось до окончания акции
*		["HOURS_LEFT"]	- часов осталось до окончания акции
*		["DAYS_DEG"]	- градус поворота индикатора дней
*		["HOURS_DEG"]	- градус поворота индикатора часов
*	)	
*/
//Из инфоблока подтягиваем ИД пользовательского поля с баллами и ИД группы, к которой принадлежат участники акции
$pointsID = (($arResult["PROPERTIES"]["point_property"]["VALUE"] == "")? $arResult["PROPERTIES"]["point_property"]["~DEFAULT_VALUE"] : $arResult["PROPERTIES"]["point_property"]["~VALUE"]);
$groupID = intval($arResult["PROPERTIES"]["group"]["VALUE"]);
$lastDatePurchase = "UF_DATE_LAST_BUY"; //Свойство последней осуществленной покупки пользователем
$arFilter = array("GROUPS_ID" => array($groupID), "ACTIVE" => "Y");
$arParamsToDB = array(
	"SELECT" => array($pointsID),
	"NAV_PARAMS" => array("nTopCount"=>"3"),
	"FIELDS" => array("ID","NAME", "LAST_NAME", "SECOND_NAME", "PERSONAL_CITY", "WORK_CITY")
);
$order="sort";//игнорируется методом но обязан быть
$rsUsers = CUser::GetList(($by=array($pointsID => "desc", $lastDatePurchase => "desc")), $order, $arFilter, $arParamsToDB);
$arResult["RATING_USERS"] = array();
$userID = ($USER->IsAuthorized())? $USER->GetID() : -1;  //Если пользователь авторизован, то сохраняем его ИД
$inFirstThree = false;	//Флаг, обозначающий, что авторизованный пользователь в первой тройке
$i = 1;					//Номер пользователя в списке
while ($arUser = $rsUsers->GetNext()) {
	$user["NAME"] = $arUser["LAST_NAME"]." ".$arUser["NAME"]." ".$arUser["SECOND_NAME"];
	$user["CITY"] = ($arUser["PERSONAL_CITY"] == '')?  $arUser["WORK_CITY"] : $arUser["PERSONAL_CITY"];
	$user["POINTS"] = intval($arUser[$pointsID]);
	$user["NUMBER"] = $i++;
	$user["ID"] = $arUser["ID"];
	if ($userID == $user["ID"])
	{
		$user["CURRENT"] = true;
		$inFirstThree = true;
	} 
	else 
	{
		$user["CURRENT"] = false;
	}
	$arResult["RATING_USERS"][] = $user;
}
unset($rsUser);
//Если авторизованный пользователь не первой тройке, то получем список всех участников и ищем его порядковый номер
if ($USER->IsAuthorized() && !$inFirstThree) 
{
	$groups = CUser::GetUserGroup($userID);
	if (in_array($groupID, $groups)) 
	{
		$arUser = CUser::GetByID($userID)->GetNext();
		$user["NAME"] = $arUser["LAST_NAME"]." ".$arUser["NAME"]." ".$arUser["SECOND_NAME"];
		$user["CITY"] = ($arUser["PERSONAL_CITY"] == '')?  $arUser["WORK_CITY"] : $arUser["PERSONAL_CITY"];
		$user["POINTS"] = intval($arUser[$pointsID]);
		$user["ID"] = $userID;
		$user["CURRENT"] = true;
		$rsUsers = CUser::GetList(($by=array($pointsID => "desc", $lastDatePurchase => "desc")), $order, $arFilter, array("FIELDS" => array("ID")));
		$i = 1;
		while ($arUser = $rsUsers->GetNext())
		{
			if ($arUser["ID"] == $user["ID"])
			{
				$user["NUMBER"] = $i;
				break;
			}
			$i++;
		}
		unset($rsUser);	
		$arResult["RATING_USERS"][] = $user;
	}
}
//Пути к изображениям
foreach ($arResult["DISPLAY_PROPERTIES"]["gift"]["FILE_VALUE"] as $image) 
{
	$arResult["GIFT"][] = array("SRC" => CFile::GetPath($image["SRC"]), "ALT" =>$image["ORIGINAL_NAME"]);
}
//Дата, когда начинает и заканчивается активность элемента инфоблока акции
$aboutAction = CIBlockElement::GetByID($arResult["ID"])->GetNext();
$dateActiveFrom = $aboutAction["DATE_ACTIVE_FROM"];
$dateActiveTo = $aboutAction["DATE_ACTIVE_TO"];
$dateCurrent = new \Bitrix\Main\Type\DateTime; //Текущая дата
//Находим разницу в днях между двумя датами
$secondsActiveFrom = MakeTimeStamp($dateActiveFrom, CSite::GetDateFormat());
$secondsActiveTo = MakeTimeStamp($dateActiveTo, CSite::GetDateFormat());
$secondsCurrent = MakeTimeStamp($dateCurrent, CSite::GetDateFormat());
$arResult["TO_END"]["DAYS_LEFT"] = bcdiv($secondsActiveTo-$secondsCurrent, 86400);
if ($arResult["TO_END"]["DAYS_LEFT"] == 0) 
{
	$arResult["TO_END"]["HOURS_LEFT"] = ParseDateTime($dateActiveTo,CSite::GetDateFormat())["HH"]-ParseDateTime($dateCurrent,CSite::GetDateFormat())["HH"];
}
else
{
	$arResult["TO_END"]["HOURS_LEFT"] = 24 - ParseDateTime($dateCurrent,CSite::GetDateFormat())["HH"];
}

$alongActionDays = bcdiv($secondsActiveTo-$secondsActiveFrom, 86400);
$arResult["TO_END"]["DAYS_DEG"] = intval((($arResult["TO_END"]["DAYS_LEFT"] / $alongActionDays)) * 360);
$arResult["TO_END"]["HOURS_DEG"] = intval((($arResult["TO_END"]["HOURS_LEFT"] / 24)) * 360);

unset($aboutAction);

if (!function_exists("rarus_word_end"))
{
	/**
	* @return 	возвращает окончание для языкового файла, 
	*			в котором выбирается слово с окончанием в зависимости от числа $num
	* @param $num - число
	*/
	function rarus_word_end($num) 
	{
		if ($num % 10 == 0 || $num % 10 >= 5 || ($num % 100 >= 10 && $num % 100 < 20))
		{
			return "_0_5_20";
		}
		else if ($num %10 == 1)
		{
			return "_1";
		}
		else
		{
			return "_2_4";
		}
	}
}
?>
