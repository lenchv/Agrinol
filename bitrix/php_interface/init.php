<?
    $fRarusEvent = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/s1/rarus_event.php";
	if (file_exists($fRarusEvent))
	{
		require($fRarusEvent);
	}
?>