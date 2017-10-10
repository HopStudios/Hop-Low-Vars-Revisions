<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';

class Hop_low_vars_revisions_tab
{

	function __construct()
	{

	}

	public function publish_tabs($channel_id, $entry_id='')
	{
		$settings = array();
		ee()->lang->loadfile('hop_low_vars_revisions');

		$settings[] = array(
			'field_id'             => 'unique_string_id',
			'field_label'          => 'Field Label',
			'field_required'       => 'n',
			'field_data'           => null,
			'field_list_items'     => null,
			'field_fmt'            => '',
			'field_instructions'   => 'Instructions in here',
			'field_show_fmt'       => 'n',
			'field_pre_populate'   => 'n',
			'field_text_direction' => 'ltr',
			'field_type'           => 'text',
			'field_maxl'           => 1024,
			'field_ta_rows'        => 6
		);

		return $settings;
	}

	function validate_publish($params)
	{
		return FALSE;
	}

	function publish_data_db($params)
	{

	}

	function publish_data_delete_db($params)
	{

	}

}
