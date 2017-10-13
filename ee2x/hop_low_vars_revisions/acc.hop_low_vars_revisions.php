<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';


class Hop_low_vars_revisions_acc {

	public $name            = 'Low Variable Revision Tracker';
	public $id              = HOP_LOW_VARS_REVISIONS_SHORT_NAME;
	public $version         = HOP_LOW_VARS_REVISIONS_VERSION;
	public $description     = 'Accessory for Low Variables Revision Tracker';
	public $sections        = array();

	function __construct()
	{

		// Set differently if we are on a publish or edit page
		if(ee()->input->get('D') == "cp" && ee()->input->get('module') == 'low_variables') {

		} else {
			return false;
		}

		// Hide the tab on all pages
		$this->sections[] = '<script type="text/javascript" charset="utf-8">$("#accessoryTabs a.'.$this->id.'").parent().remove();</script>';

		// Add a var with CP url to fetch revisions as JSON
		$addon_cp_url = str_replace('&amp;', '&', BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module='.HOP_LOW_VARS_REVISIONS_SHORT_NAME);
		$load_revisions_endpoint = $addon_cp_url.'&method=loadRevisions';
		$show_revision_endpoint = $addon_cp_url.'&method=showRevision';
		$this->sections[] = '<script type="text/javascript" charset="utf-8"> var hlvrLoadUrl = "'.$load_revisions_endpoint.'"; var hlvrShowUrl = "'.$show_revision_endpoint.'"; </script>';

		// Add our main script to load revisions list
		$script = file_get_contents(PATH_THIRD.'hop_low_vars_revisions/assets/low_var_revisions.js');
		$this->sections[] = '<script type="text/javascript" charset="utf-8">'.$script.'</script>';
	}

	/**
	 * Set Sections
	 * This function must exist, but is empty
	 */
	public function set_sections() {

	}


}

/* End of file  */
