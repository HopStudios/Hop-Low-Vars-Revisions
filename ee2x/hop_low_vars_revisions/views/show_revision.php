<h1><?=$variable_label?></h1>
<h3><code><?=$variable_name?></code></h3>
<br>
<div id="templateEditor" class="formArea">

	<div class="clear_left" id="template_details" style="margin-bottom: 0">

		<?=ee()->localize->format_date('%n/%d/%Y %g:%i%A', $revision_date)?> by <?=$member_name?>

	</div>

	<div id="template_create" class="pageContents">
		<textarea name="template_data" cols="100" rows="20" id="template_data" style="border: 0;"><?=$variable_data?></textarea>
	</div>
</div>