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
$this->setFrameMode(true);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");
?>
<div class="bx-newslist">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<div class="action-container">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="action-item <?=(($arItem['ACTIVE_ON_DATE'])? "active" : "")?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="title-line">
			<div class="status-action">
				<?=(($arItem['ACTIVE_ON_DATE'])? GetMessage("CT_BNL_ACTIVE") : GetMessage("CT_BNL_NO_ACTIVE"))?>
			</div>
			<div class="title"><?="<a href=\"".$arItem['DETAIL_PAGE_URL']."\">".GetMessage("CT_BNL_ACTION_SIGN").$arItem["NAME"]."!</a>"?></div>
			<div class="date-container">
				<?=GetMessage("CT_BNL_DATE_FROM")." ".$arItem["DISPLAY_ACTIVE_FROM"]." ".GetMessage("CT_BNL_DATE_TO")." ".$arItem["DISPLAY_ACTIVE_TO"]?>
			</div>
		</div>
		<div class="description-block">
			<?echo $arItem["~PREVIEW_TEXT"];?>
		</div>
		<div class="detail-line">
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo GetMessage("CT_BNL_GOTO_DETAIL")?></a>
		</div>
		<div class="additional-block">
			<?foreach($arItem["FIELDS"] as $code=>$value):?>
				<?if($code == "SHOW_COUNTER"):?>
					<div class="bx-newslist-view"><i class="fa fa-eye"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
						<?=intval($value);?>
					</div>
				<?elseif(
					$value
					&& (
						$code == "SHOW_COUNTER_START"
						|| $code == "DATE_ACTIVE_FROM"
						|| $code == "ACTIVE_FROM"
						|| $code == "DATE_ACTIVE_TO"
						|| $code == "ACTIVE_TO"
						|| $code == "DATE_CREATE"
						|| $code == "TIMESTAMP_X"
					)
				):?>
				<?elseif($code == "TAGS" && $value):?>
					<div class="bx-newslist-tags"><i class="fa fa-tag"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
						<?=$value;?>
					</div>
				<?elseif(
					$value
					&& (
						$code == "CREATED_USER_NAME"
						|| $code == "USER_NAME"
					)
				):?>
					<div class="bx-newslist-author"><i class="fa fa-user"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
						<?=$value;?>
					</div>
				<?elseif ($value != ""):?>
					<div class="bx-newslist-other"><i class="fa"></i> <?=GetMessage("IBLOCK_FIELD_".$code)?>:
						<?=$value;?>
					</div>
				<?endif;?>
			<?endforeach;?>
			
			<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<?
				if(is_array($arProperty["DISPLAY_VALUE"]))
					$value = implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
				else
					$value = $arProperty["DISPLAY_VALUE"];
				?>
				<?if($arProperty["CODE"] == "FORUM_MESSAGE_CNT"):?>
					<div class="bx-newslist-comments"><i class="fa fa-comments"></i> <?=$arProperty["NAME"]?>:
						<?=$value;?>
					</div>
				<?endif;?>
			<?endforeach;?>

			<div class="row">
			<?if($arParams["USE_RATING"]=="Y"):?>
				<div class="col-xs-7 text-right">
					<?$APPLICATION->IncludeComponent(
						"bitrix:iblock.vote",
						"flat",
						Array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_ID" => $arItem["ID"],
							"MAX_VOTE" => $arParams["MAX_VOTE"],
							"VOTE_NAMES" => $arParams["VOTE_NAMES"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
							"SHOW_RATING" => "N",
						),
						$component
					);?>
				</div>
			<?endif?>
			</div>
		</div>
	</div>
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>