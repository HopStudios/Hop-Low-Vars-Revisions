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

        //Set differently if we are on a publish or edit page
        if(         ee()->input->get('D') == "cp" && ee()->input->get('module') == 'low_variables') {
            
            }
		else {
			return false;
			}

        //Hide the tab on all pages
        $this->sections[] = '<script type="text/javascript" charset="utf-8">$("#accessoryTabs a.'.$this->id.'").parent().remove();</script>';
    }

    /**
     * Set Sections
     * This function must exist, but is empty
     */
    public function set_sections() {

        } // end public function set_sections()


}

/* End of file  */
