<?php

namespace Navatar\Plugin\Listeners;

use Navatar\Plugin\Controllers\Navatars;
use Navatar\Plugin\Main;

class UserEvents
{
	public function activate($data)
	{
		Navatars::assign($data);
		//Main::log($data, 'activation-trigger');
	}


	public function login($data)
	{
		Navatars::assign($data);
		//Main::log($data,'new-login-trigger');
	}



}