<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';

class Hop_low_vars_revisions_mcp {

	public function __construct()
	{
		$this->cp_module_name = lang('hop_low_vars_revisions_module_name');
		$this->cp_base_url   =	BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.HOP_LOW_VARS_REVISIONS_SHORT_NAME;
        $this->form_base_url = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.HOP_LOW_VARS_REVISIONS_SHORT_NAME;

		ee()->view->cp_page_title = $this->cp_module_name;

        ee()->cp->set_breadcrumb($this->cp_base_url,$this->cp_module_name);

		ee()->cp->set_right_nav(array(
 			'Home' 		=> $this->cp_base_url.AMP.'method=index',
			'Settings'  => $this->cp_base_url.AMP.'method=settings'
			));
	}

	public function index()
	{


		return 'Hello World!';
	}
}
