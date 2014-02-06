<?php

namespace Roku;

class Model_Device extends \Model
{

	public function search($st = '')
	{
		require_once(APPPATH.'modules/upnp/vendor/phpupnp.class.php');
		$upnp = new \phpUPnP();
		$found = array();

		switch($st)
		{
		case 'ecp':
			$found = $upnp->mSearch('roku:ecp');
			break;
		case 'dial':
			//DIAL isnt working on the roku 2 xs from what I could find.
			break;
		default:
			$found = $upnp->mSearch(); //just get everything for now
			break;
		}
		return $found;
	}
}
