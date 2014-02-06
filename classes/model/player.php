<?php

namespace Roku;

class Model_Player extends Model_Remote
{
	public function launch($url)
	{
		$request = 'launch/dev?streamformat=mp4&url='.urlencode($url);
		$this->curl($request);
		return true;
	}

	public function simpleplay($ctrlurl,$url)
	{
		$request = $ctrlurl.'?streamformat=mp4&url='.urlencode($url);
		$this->curl($request);
		return $request;
	}
}
