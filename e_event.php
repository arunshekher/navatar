<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
*/

if (!defined('e107_INIT')) { exit; }

use Navatar\Plugin\Controllers\Navatar;
require_once __DIR__ . '/vendor/autoload.php';

class navatar_event
{

	public function __construct( protected Navatar $navatar = new Navatar())
	{
		
	}

	public function config()
	{

		$event = array();

		// Example 1: core event ("login")
		$event[] = array(
			'name'		=> "login", // when this event is triggered... (for core events, see http://e107.org/developer-manual/classes-and-methods#events)
			'function'	=> "myfunction", // ..run this function (see below). 
		);

		// Example 2: core plugin event ("user_forum_post_created")
		$event[] = array(
			'name'		=> "user_signup_activated", // event triggered in the forum plugin when a user submits a new forum post 
			'function'	=> "myfunction", // ..run this function (see below). You can run the same function on different events. 
		);
	
		return $event;
	}


	public function myfunction($data) // the method to run.
	{
		$this->navatar->assignNavatar($data);
		// var_dump($data);
	}

	public function anotherfunction($data) // the method to run.
	{
		// var_dump($data);
	}

} 
