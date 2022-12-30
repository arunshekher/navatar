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


class navatar_event
{

	/**
	 * Configure functions/methods to run when specific e107 events are triggered.
	 * 
	 * For a list of core events, please visit: http://e107.org/developer-manual/classes-and-methods#events
	 * 
	 * Developers can trigger their own events using: e107::getEvent()->trigger('plugin_event', $array);
	 * Where 'plugin' is the folder of their plugin and 'event' is a unique name of the event.
	 * Other plugins can then 'listen' to this custom event by defining it in THEIR e_event.php addon within the config() method. 
	 * 
	 * $array is data which is sent to the triggered function. eg. myfunction($array) in the example below.
	 *
	 * @return array
	 */
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
		// var_dump($data);
	}

	public function anotherfunction($data) // the method to run.
	{
		// var_dump($data);
	}

} 
