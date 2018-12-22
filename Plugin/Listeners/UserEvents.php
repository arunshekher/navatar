<?php

namespace Navatar\Plugin\Listeners;

use Navatar\Plugin\Controllers\NavatarController;
use Navatar\Plugin\Navatar;

class UserEvents
{
	public function confirmed($data)
	{
		Navatar::log('signup confirmed!', 'activation-trigger');
	}


	public function login($data)
	{
		//Navatar::log($data, 'login-trigger');

		NavatarController::create($data);
	}



}