<h1><?= $variable_label ?></h1>
<h3><code><?= $variable_name ?></code></h3>
<br>
<div id="templateEditor" class="formArea">

	<div class="clear_left" id="template_details" style="margin-bottom: 0">

		<?= ee()->localize->format_date('%n/%d/%Y %g:%i%A', $revision_date) ?> by <?= $member_name ?>

	</div>

	<div id="template_create" class="pageContents">
		<form method="post" action="index.php?/cp/addons_modules/show_module_cp&module=low_variables&method=save" enctype="multipart/form-data" id="low-variables-form">
			<input type="hidden" name="<?=$csrf_token_name?>" value="<?= $csrf_token_value ?>" />
			<input type="hidden" name="all_ids" value="<?= $var_id ?>" />
			<input type="hidden" name="group_id" value="<?= $group_id ?>" />
			<?php if (isset($variable_data)) { ?>
			<textarea name="template_data" cols="100" rows="20" id="template_data" style="border: 0;"><?= $variable_data ?></textarea>
			<?php } ?>
			<?php if (isset($matrix_display)) {
				echo $matrix_display;
			} ?>
			<input type="hidden" name="var[<?= $var_id ?>][trigger_revisions]" value="1"/>
			<button type="submit" class="submit" style="float: right;">Save this version</button>
		</form>
	</div>
</div>