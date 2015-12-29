<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="action-block">
	<div class="table-block">
		<div class="title"><b><?=GetMessage("ACTION_SIGN")?>! <?=$arResult["NAME"]?>!</b></div>
		<table class="action-table" cellspacing="0">
			<tr class="action-head">
				<th class="first-column">№</th>
				<th><?=GetMessage("ACTION_FIO")?></th>
				<th><?=GetMessage("ACTION_CITY")?></th>
				<th><?=GetMessage("ACTION_POINTS")?></th>
			</tr>
<?foreach ($arResult["RATING_USERS"] as $user):?>
			<tr class="action-user <?=(($user["CURRENT"])? "current-user" : "")?>">
				<td class="first-column"><?=$user["NUMBER"]?></td>
				<td><?=$user["NAME"]?></td>
				<td><?=$user["CITY"]?></td>
				<td><?=$user["POINTS"]?></td>
			</tr>
<?endforeach;?>	
		</table>
		<div class="action-link-right"><a href="<?=$arResult["DETAIL_PAGE_URL"]."#rating"?>"><?=GetMessage("ACTION_LOOK_ALL_RATING")?></a></div>
		<div class="action-link-left"><a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><?=GetMessage("ACTION_CONDITION")?></a></div>
	</div>
	<div class="timer-block">
		<div class="title"><?=GetMessage("ACTION_TO_THE_END")?></div>
		<div class="clock-container">
			<div class="clock">
				<div class="clock-spinner">
					<div class="spinner" style="transform: rotate(<?=$arResult["TO_END"]["DAYS_DEG"]?>deg);"></div>
					<div class="filler <?=($arResult["TO_END"]["DAYS_DEG"] > 180)? "high-fifth" : "low-fifth"?>">
						<div class="circle-line"></div>
					</div>
					<div class="clock-wrapper <?=($arResult["TO_END"]["DAYS_LEFT"] >= 100)? "third-sign" : ""?> ">
						<?=$arResult["TO_END"]["DAYS_LEFT"]?>
					</div>
				</div>
				<div class="sign"><?=GetMessage("ACTION_DAYS".rarus_word_end($arResult["TO_END"]["DAYS_LEFT"]))?></div>
			</div>
			<div class="clock">
				<div class="clock-spinner">
					<div class="spinner" style="transform: rotate(<?=$arResult["TO_END"]["HOURS_DEG"]?>deg);"></div>
					<div class="filler <?=($arResult["TO_END"]["HOURS_DEG"] > 180)? "high-fifth" : "low-fifth"?>">
						<div class="circle-line"></div>
					</div>
					<div class="clock-wrapper"><?=$arResult["TO_END"]["HOURS_LEFT"]?></div>
				</div>
				<div class="sign"><?=GetMessage("ACTION_HOURS".rarus_word_end($arResult["TO_END"]["HOURS_LEFT"]))?></div>
			</div>
		</div>
	</div>
	<div class="gifts-block">
		<div class="sign-gifts"><?=GetMessage("ACTION_GIFTS_SIGN")?></div>
		<div class="image-container">
<?foreach ($arResult["GIFT"] as $image):?>
			<img src="<?=$image["SRC"]?>" alt="<?=$image["ALT"]?>">
<?endforeach?>
		</div>
	</div>
</div>