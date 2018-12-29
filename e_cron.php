<?php

class navatar_cron
{
	public function config()
	{
		$cron = array();

		$cron[] = array(
			'name'            => "Create Navatars via cron",  // Displayed in admin area. .
			'function'        => "sheduledAssignNavatar",    // Name of the function which is defined below.
			'category'        => 'content',           // Choose between: mail, user, content, notify, or backup
			'description'     => "Creates navatars for already activated users who doesn't have an avatar"  // Displayed in admin area.
		);

		return $cron;
	}

	public function sheduledAssignNavatar()
	{
		//file_put_contents(e_PLUGIN . 'navatar/logs/cron-log.txt', date('l jS \of F Y h:i:s A') . PHP_EOL, FILE_APPEND);
	}

}