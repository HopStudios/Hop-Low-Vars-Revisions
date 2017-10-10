<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';

class Hop_low_vars_revisions_upd
{

	var $module_name = 'Hop_low_vars_revisions';
	var $version = HOP_LOW_VARS_REVISIONS_VERSION;

	public function __construct()
	{

	}

	public function install()
	{
		// install module
		$data = array(
			'module_name' => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);

		ee()->db->insert('modules', $data);


		/*
		// install actions
		$actions = array(
			array(
				'class' => $this->module_name ,
				'method' => 'method_to_call'
			)
		);

		foreach ($actions as $action)
		{
			ee()->db->insert('actions', $action);
		}
		*/


		/*
		// install publish page updates
		ee()->load->library('layout');
		ee()->layout->add_layout_tabs($this->tabs(), $this->module_name);
		*/


		/*
		// create tables
		ee()->load->dbforge();
		ee()->dbforge->add_field("`id` int(11) NOT NULL AUTO_INCREMENT");
		ee()->dbforge->add_field("`field_name` varchar(100) NULL");
		ee()->dbforge->add_key("id", TRUE);
		ee()->dbforge->create_table('table_name');
		*/

		return TRUE;
	}

	public function update($current = '')
	{
		if ($current == $this->version)
		{
			return FALSE;
		}

		if ($current < 2.0)
		{
			// Do your update code here
		}

		return TRUE;
	}

	public function uninstall()
	{
		// remove module
		ee()->db->where('module_name', $this->module_name);
		ee()->db->delete('modules');

		// remove actions
		// remove module
		ee()->db->where('class', $this->module_name);
		ee()->db->delete('actions');

		// remove publish page updates
		ee()->load->library('layout');
		ee()->layout->delete_layout_tabs($this->tabs(), $this->module_name);

		// drop tables
		// ee()->load->dbforge();
		// ee()->dbforge->drop_table('table_name');

		return TRUE;
	}

	public function tabs()
	{
		$tabs[$this->module_name] = array(
			'unique_string_id'=> array(
				'visible' => 'true',
				'collapse' => 'false',
				'htmlbuttons' => 'true',
				'width' => '100%'
			)
		);

		return $tabs;
	}

}
