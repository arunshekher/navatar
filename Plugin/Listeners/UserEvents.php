<?php

namespace Navatar\Plugin\Listeners;

use Navatar\Plugin\Controllers\Navatar;
use Navatar\Plugin\Main;

class UserEvents
{
	public function activate($data)
	{
		Navatar::create($data);
		//Main::log($data, 'activation-trigger');
	}


	public function login($data)
	{
		Navatar::create($data);
		//Main::log($data,'new-login-trigger');
	}



}