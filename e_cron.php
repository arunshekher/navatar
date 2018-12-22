<?php

class navatar_cron       // plugin-folder name + '_cron'.
{
	public function config() // Setup
	{
		$cron = array();

		$cron[] = array(
			'name'            => "Create Navatars via cron",  // Displayed in admin area. .
			'function'        => "createNavatarsWithCron",    // Name of the function which is defined below.
			'category'        => 'content',           // Choose between: mail, user, content, notify, or backup
			'description'     => "Creates navatars for already activated users who doesn't have an avatar"  // Displayed in admin area.
		);

		return $cron;
	}

	public function createNavatarsWithCron()
	{
		// Do Something.
	}

}