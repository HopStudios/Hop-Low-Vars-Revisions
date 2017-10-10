<?php  if ( ! defined('BASEPATH')) { exit('No direct script access allowed'); }

require_once PATH_THIRD.'hop_low_vars_revisions/_config.php';

class Hop_low_vars_revisions
{

	public function __construct()
	{

	}


/**
* Extends the channel entries tag
*
**/
	private function _extend_channel_entries($entrylist) {

		// Include the class if it isn't included
		if(!class_exists('Channel'))
		{
		// First party modules or plugins
		require_once(APPPATH.'modules/channel/mod.channel.php');
		// Third party would be
		// require_once(PATH_THIRD.'package/mod.package.php');
		}

		ee()->TMPL->tagparams['fixed_order'] = $entrylist;
		ee()->TMPL->tagparams['status'] = 'open';
		ee()->TMPL->tagparams['limit'] = '9999';
		ee()->TMPL->tagparams['dynamic'] = 'no';

		$C = new Channel();
		$this->return_data = $C->entries();
		return $this->return_data;
		}

}
