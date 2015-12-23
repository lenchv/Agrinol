<?
/**
*	Обработчик события подтверждения оплаты товара
*/
function __s1_event_sale_OnSalePayOrder($id, $val)
{
	$currentUserId = $GLOBALS['USER']->GetID(); //Идентификатор текущего пользователя, по идее администратор
	$idRatingGroup = 17;						//группа акции
	$arOrder=CSaleOrder::GetByID($id);			//информация о заказе
	$price = intval(ceil(floatval($arOrder["PRICE"])));	//стоимость заказа
	
	$userId = intval($arOrder["EMP_PAYED_ID"]);	//пользователь, который оплатил заказ
	$arUserData = CUser::GetByID($userId)->Fetch();	//Информация о пользователе
	
	$userGroups = CUser::GetUserGroup($userId);	//ИД групп, к которым принадлежит пользователь
	//Если пользователя нет в акционной группе, и он совершил заказ более чем на 900 грн, то добавить его в группу
	if (!in_array($idRatingGroup, $userGroups)) 
	{
		if ($price >= 900 && $val === 'Y') 
		{
			$userGroups[] = $idRatingGroup;
			CUser::SetUserGroup($userId, $userGroups);
		}	
	}
	//Если пользователь, совершивший заказ, в акционной группе
	if (in_array($idRatingGroup, $userGroups)) 
	{
		$points = $price * 5;
		$payedUser = new CUser;
		//Если оплата подтверждается, то добавить баллы
		if ($val === 'Y') 
		{
			$points = intval($arUserData['UF_ACTION_POINTS']) + $points;
			$payedUser->Update($userId, array( "UF_ACTION_POINTS" => $points));
		} 
		//Если оплата отменяется, то вычесть баллы
		else if ($val === 'N') 
		{
			if ($arUserData['UF_ACTION_POINTS'] >= $points) 
			{
				$points = intval($arUserData['UF_ACTION_POINTS']) - $points;
				$payedUser->Update($userId, array( "UF_ACTION_POINTS" => $points));
			}
		}
		//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/s1/log.txt", $payedUser->GetID()."\n", FILE_APPEND | LOCK_EX);	
	} 
	//$_GLOBALS['USER'] = $currentUser;
	/*if ($GLOBALS['USER']->Authorize($currentUserId))
	{
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/s1/log.txt", "ok\n", FILE_APPEND | LOCK_EX);	
	} else 
	{
		file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/s1/log.txt", "ne ok\n", FILE_APPEND | LOCK_EX);	
	}*/
	//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/s1/log.txt", " ".$price." ".$id." ".$val."\n", FILE_APPEND | LOCK_EX);
}
/**
*	Событие, которое проиходит после подтверждения оплаты товара
*/
AddEventHandler("sale", "OnSalePayOrder", '__s1_event_sale_OnSalePayOrder');
?>