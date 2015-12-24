<?
class CRarusEvents {
	/**
	*	Обработчик события подтверждения оплаты товара
	*/
	function OnSalePayOrderHandler($id, $val)
	{
		$currentUserId = $GLOBALS['USER']->GetID(); //Идентификатор текущего пользователя, по идее администратор
		$idRatingGroup = 5;							//группа акции
		$curTo = "UAH"; 							//тип гривневой цены
		$arOrder=CSaleOrder::GetByID($id);			//информация о заказе
		$price = CCurrencyRates::ConvertCurrency(floatval($arOrder["SUM_PAID"]),$arOrder["CURRENCY"], $curTo);
		$price = intval(ceil($price));				//стоимость заказа
		$userId = intval($arOrder["USER_ID"]);		//пользователь, который оплатил заказ
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

		$points = $price * 5;
		$payedUser = new CUser;
		//Если оплата подтверждается, то добавить баллы
		if ($val === 'Y' && in_array($idRatingGroup, $userGroups)) 
		{
			$points = intval($arUserData['UF_ACTION_POINTS']) + $points;
			$payedUser->Update($userId, array( "UF_ACTION_POINTS" => $points));
		} 	
		else if ($val === 'N')  //Если оплата отменяется, то вычесть баллы
		{
			$price = CCurrencyRates::ConvertCurrency(floatval($arOrder["PRICE"]),$arOrder["CURRENCY"], $curTo);
			$price = intval(ceil($price));				//вычитаем полную стоимость
			$points = $price*5;
			if ($arUserData['UF_ACTION_POINTS'] >= $points) 
			{
				$points = intval($arUserData['UF_ACTION_POINTS']) - $points;
				$payedUser->Update($userId, array( "UF_ACTION_POINTS" => $points));
				//Если очков стало меньше 4500, то исключаем пользователя из группы участников
				if (in_array($idRatingGroup, $userGroups) && $points < 4500) 
				{
					$indexGroup = array_search($idRatingGroup, $userGroups);
					if (isset($userGroups[$indexGroup]))
					{
						unset($userGroups[$indexGroup]);
						CUser::SetUserGroup($userId, $userGroups);
					}
				}
			}
		}
		unset($payedUser);
	}
}

/**
*	Событие, которое проиходит после подтверждения оплаты товара
*/
AddEventHandler("sale", "OnSalePayOrder", array("CRarusEvents", "OnSalePayOrderHandler"));
?>