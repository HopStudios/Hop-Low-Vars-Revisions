<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';

class Hop_low_vars_revisions_ext
{

	public $name = 'Low Variable Revision Tracker';
	public $version = HOP_LOW_VARS_REVISIONS_VERSION;
	public $description = 'This addon adds Low Variables (text types ONLY) to the revision tracker';
	public $settings_exist = 'n';
	public $docs_url = '';
	public $settings = array();

	public function __construct($settings='')
	{
		$this->settings = $settings;
	}

	public function activate_extension()
	{
		$this->settings = array(
			// 'a setting' => 'a value'
		);


		foreach (array(
			'low_variables_post_save',
		) as $hook)
		{
			ee()->db->insert('extensions', array(
				'class'		=> __CLASS__,
				'method'	=> $hook.'_action',
				'hook'		=> $hook,
				'settings'	=> serialize($this->settings),
				'priority'	=> 10,
				'version'	=> $this->version,
				'enabled'	=> 'y'
			));
		}
	}

	public function low_variables_post_save_action($var_ids, $skipped)
	{
		// grab the variable values
		$query = ee()->db->select("*")
			->from("global_variables")
			->where_in('variable_id',$var_ids)
			->get();
		
		$result = $query->result_array();
		
		// reindex our result by variable ID for looking up later
		$vardata = array();
		foreach($result as $varitem) {
			$key = $varitem['variable_id'];
			$vardata[$key] = $varitem;
			}

			
		// for each variable ID saved
		foreach($var_ids as $key=>$varid) {
			$myvardata = $vardata[$varid];
			
			$revision = array(
					'item_id'       => $varid,
					'item_table'    => 'exp_global_variables',
					'item_field'    => 'variable_data',
					'item_date'     => ee()->localize->now,
					'item_author_id'=> ee()->session->userdata('member_id'),
					'item_data'     => $myvardata['variable_data']
					);
			
		// check it against previous revision tracker (since it's over-saving, we don't want duplicate rev tracker entries)
			$revsql =  "SELECT * FROM `exp_revision_tracker`
						WHERE item_table = 'exp_global_variables'
							AND item_id = {$varid}
						ORDER BY item_date DESC
						LIMIT 1;";
						
			$revresult = ee()->db->query($revsql)->row_array();
			
		// if there is not a rev tracker entry present, add one
			if(!sizeof($revresult) > 0) { 			
				ee()->db->insert('exp_revision_tracker', $revision);
				}
			else {
				$old_var_data = trim($revresult['item_data']);
				$new_var_data = trim($myvardata['variable_data']);
				// if there is a rev tracker entry and they're different, add a line to the revision tracker
				if($old_var_data != $new_var_data) {
					ee()->db->insert('exp_revision_tracker', $revision);
					}
			// otherwise they're duplicates, don't add anything
				}
		}
	}




	public function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		if ($current < '1.0')
		{
			// Update to version 1.0
		}

		ee()->db->where('class', __CLASS__);
		ee()->db->update('extensions', array('version' => $this->version));
	}

	public function disable_extension()
	{
		ee()->db->where('class', __CLASS__);
		ee()->db->delete('extensions');
	}

}
