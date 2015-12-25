<?if (defined('IS_HOMEPAGE')):?>
	<div class="inform-line">
		<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
		        "AREA_FILE_SHOW" => "file", 
		        "PATH" => SITE_TEMPLATE_PATH."/include_areas/inform-panel.php"
		    )
		);?>
	</div>
<?endif?>