<?php

namespace Roku;

class Controller_Index extends \Controller
{
	public $remote;
	public $device;
	public function before()
	{
		$this->remote = new Model_Player();
		$this->device = new Model_Device();

		//instead of mongo, either accept a provided controller url, or ecp scan for first hit (maybe present a list?)
		$mongo = \Mongo_Db::instance();
		$devices = $mongo->get('devices');
		foreach($devices as $d)
		{
			if($d['base_url']&&$d['type']=='roku')
			{
				$this->remote->location = $d['base_url'];
			}
		}
	}

	public function action_discover()
	{
		$ecps = $this->device->search('ecp');
		foreach($ecps as $ecp)
		{
			var_dump($ecp);
		}
		return $ecps;
	}


	public function action_index()
	{
		
		$view = \View::forge('index');

		$view->channels = $this->remote->channels();
		$view->playlists = $playlists = array();
		$view->movies = $movies = array();
		$view->devices = $devices = array();
		if(\Input::post('launch')){
			if(\Input::post('url')){
				$url = \Input::post('url');
			}
			$this->load($url,'mp4');
		}
		
		return $view;
	}

	public function load($url = '', $format = 'mp4')
	{
		$this->remote->launch($url);
		return true;
	}

	public function action_keypress()
	{
		switch(\Input::get('button'))
		{
			case 'home':
				$this->remote->home();
			break;
			case 'select':
				$this->remote->ok();
			break;
			case 'rewind':
				$this->remote->rewind();
			break;
			case 'fforward':
				$this->remote->fforward();
			break;
			case 'play':
				$this->remote->play();
			break;
			case 'up':
				$this->remote->dPad('up');
			break;
			case 'down':
				$this->remote->dPad('down');
			break;
			case 'left':
				$this->remote->dPad('left');
			break;
			case 'right':
				$this->remote->dPad('right');
			break;
			case 'search':
				$this->remote->search();
			break;
			case 'back':
				$this->remote->back();
			break;
			default:
				$this->remote->ok();
			break;
		}
		return true;
	}

	public function action_channel()
	{
		$view = \View::forge('index');
		if(\Input::post('channel'))
		{
			$this->remote->loadChannel(\Input::post('channel'));
		}
		$view->channels = $channels = $this->remote->channels();
		var_dump($channels);
		return $view;
	}

	public function action_search()
	{
		return $this->remote->search(\Input::post('query'));
	}
}
