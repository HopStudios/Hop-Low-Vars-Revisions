<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';

class Hop_low_vars_revisions_mcp {

	public function __construct()
	{
		$this->cp_module_name	= lang('hop_low_vars_revisions_module_name');
		$this->cp_base_url		= BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.HOP_LOW_VARS_REVISIONS_SHORT_NAME;
		$this->form_base_url	= 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.HOP_LOW_VARS_REVISIONS_SHORT_NAME;

		ee()->view->cp_page_title = $this->cp_module_name;

		ee()->cp->set_breadcrumb($this->cp_base_url,$this->cp_module_name);
	}

	public function index()
	{
		$low_var_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=low_variables';
		return 'To view the variable revisions, go to <a href="'.$low_var_url.'">Low Variables</a> add-on.';
	}

	public function loadRevisions()
	{
		$var_name = ee()->input->get('var_name');

		if (!$var_name) {
			@header('Content-Type: application/json');
			exit(json_encode(array()));
		}

		$query = ee()->db->select('gv.variable_id, gv.site_id, gv.variable_name, rt.tracker_id, rt.item_date, rt.item_author_id, m.screen_name, m.username')
				->from('global_variables AS gv')
				->join('revision_tracker AS rt', 'gv.variable_id = rt.item_id')
				->join('members AS m', 'm.member_id = rt.item_author_id')
				->where('gv.variable_name', $var_name)
				->where('rt.item_table', 'exp_global_variables')
				->order_by('rt.item_date', 'desc')
				->get();

		$revisions = array();
		foreach ($query->result() as $row)
		{
			// echo $row->title;
			$member_name = trim($row->screen_name) != ''?$row->screen_name:$row->username;
			$revisions[] = array(
				'revision_id' => $row->tracker_id,
				'revision_desc' => ''.ee()->localize->format_date('%n/%d/%Y %g:%i%A', $row->item_date).' ('.$member_name.')'
			);
		}

		@header('Content-Type: application/json');
		// return json_encode($revisions);
		exit(json_encode($revisions));
	}

	public function showRevision()
	{
		if ( ! ee()->cp->allowed_group('can_access_design'))
		{
			show_error(lang('unauthorized_access'));
		}

		if ( ! $id = ee()->input->get_post('rev_id'))
		{
			show_error(lang('unauthorized_access'));
		}

		$query = ee()->db->select('gv.variable_id, gv.site_id, gv.variable_name, rt.tracker_id, rt.item_date, rt.item_author_id, rt.item_data, m.screen_name, m.username, lv.variable_label')
			->from('global_variables AS gv')
			->join('revision_tracker AS rt', 'gv.variable_id = rt.item_id')
			->join('members AS m', 'm.member_id = rt.item_author_id')
			->join('low_variables AS lv', 'lv.variable_id = gv.variable_id')
			->where('rt.tracker_id', $id)
			->get();
		
		if (count($query->result()) == 0)
		{
			show_error('Revision '.$id.' not found');
		}

		ee()->view->cp_page_title = 'View Revision - '.$this->cp_module_name;

		$vars = array();
		$result = $query->result();
		$result = $result[0];

		$vars['variable_label'] = $result->variable_label;
		$vars['variable_name'] = $result->variable_name;
		$vars['variable_data'] = $result->item_data;
		$vars['revision_date'] = $result->item_date;
		$vars['member_name'] = trim($result->screen_name) != ''?$result->screen_name:$result->username;

		return ee()->load->view('show_revision', $vars, TRUE);
	}
}
