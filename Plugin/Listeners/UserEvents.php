<?php

namespace Navatar\Plugin\Listeners;

use Navatar\Plugin\Controllers\Navatar;
use Navatar\Plugin\Main;

class UserEvents
{
	public function confirmed($data)
	{
		Main::log('signup confirmed!', 'activation-trigger');
	}


	public function login($data)
	{
		Main::log($data,'new-login-trigger');
		Navatar::create($data);
	}



}