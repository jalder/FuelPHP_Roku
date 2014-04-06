<?php
/**
 * Model_Remote for Roku
 * sends ECP (external control protocol) controls to Roku devices.
 * autodiscovers Roku device via UPnP with ST of roku:ecp
 * 
 * @author jalder
 * 
 * 
 * **/

namespace Roku;


class Model_Remote extends \Model
{
	public $location = '';

	public function curl($request)
	{
		$url = $this->location.$request;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_exec($ch);
		curl_close($ch);
		return true;
	}

	public function channels()
	{
		$curl = \Request::forge($this->location.'query/apps','curl');
		$curl->set_method('get');
		try
		{
			$curl->execute();
		}
		catch(\RequestException $e)
		{
			return array();
		}
		//var_dump($curl->response()->body);
		$xml = simplexml_load_string($curl->response()->body);
		//var_dump($xml);
		$list = array();
		foreach($xml->app as $app)
		{
			$attr = $app->attributes()->id;
			//var_dump($attr);
			$list[(string)$attr] = (string)$app;
		}
		//var_dump($list);
		//var_dump(\Format::forge($curl->response()->body,'xml'));
		return $list;
		//return \Format::forge($curl->response()->body,'xml')->to_array();
	}

	public function loadChannel($channel_id)
	{
		//var_dump($channel_id);
		//die();
		return $this->curl('launch/'.$channel_id);
	}

	public function home()
	{
		return $this->curl('keypress/home');
	}

	public function back()
	{
		return $this->curl('keypress/back');
	}

	public function dPad($dir = 'up')
	{
		switch($dir)
		{
		case 'up':
			$dir = 'up';
			break;
		case 'down':
			$dir = 'down';
			break;
		case 'left':
			$dir = 'left';
			break;
		case 'right':
			$dir = 'right';
			break;
		default:
			$dir = 'up';
			break;
		}

		return $this->curl('keypress/'.$dir);
	}

	public function ok()
	{
		return $this->curl('keypress/select');
	}

	public function options()
	{
		return $this->curl('keypress/info');
	}

	public function rewind()
	{
		return $this->curl('keypress/rev');
	}

	public function fforward()
	{
		return $this->curl('keypress/fwd');
	}

	public function pause()
	{
		return $this->curl('keypress/play');
	}

	public function play()
	{
		return $this->curl('keypress/play');
	}

	public function type($query)
	{
		foreach(str_split($query) as $char)
		{
			$this->curl('keypress/Lit_'.urlencode($char));
		}
		return true;
	}

	//This isn't really workable as a hack...
	public function search($query = '')
	{
		//$this->curl('keypress/search');
		$this->home();
		$this->dPad('up');
		$this->dPad('up');
		$this->dPad('up');
		$this->ok();

		if($query)
		{
			$this->type($query);
		}

		for($i=10;$i<7;$i++)
		{
			$this->dPad('right');
		}
		return true;
	}

}
