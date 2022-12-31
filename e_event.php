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
use Navatar\Plugin\Main;
require_once __DIR__ . '/vendor/autoload.php';

class navatar_event /** todo: base it on a Listenable interface */
{

	public function __construct(
		private $currentEventName = '', 
		protected Navatar $navatar = new Navatar())
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
			'function'	=> "anotherfunction", // ..run this function (see below). You can run the same function on different events. 
		);
	
		return $event;
	}


	public function myfunction($data) // the method to run.
	{
		$this->eventData = $data;
		//$this->navatar->assignNavatar($data);
		$this->log();
		// var_dump($data);
	}

	public function anotherfunction($data) // the method to run.
	{
		$this->eventData = $data;
		//$this->navatar->assignNavatar($data);
		$this->log();
		// var_dump($data);
	}


	private function log(): void
	{
		file_put_contents(
			\e_PLUGIN . 'navatar/event-test-logs.txt', 
			var_export($this, true) . PHP_EOL, 
			FILE_APPEND);
	}

} 
