<?php

use Navatar\Plugin\Listeners\UserEvents;

if ( ! defined('e107_INIT')) {
	exit;
}
require_once __DIR__ . '/vendor/autoload.php';

$prefs = e107::getPlugPref('navatar');

if ($prefs['master_active']) {

	if ($prefs['user_trigger_event'] === 'both') {
		e107::getEvent()->register('user_signup_activated',
			[UserEvents::class, 'confirmed']);
		e107::getEvent()->register('login', [UserEvents::class, 'login']);
	}

	if ($prefs['user_trigger_event'] === 'activate') {
		e107::getEvent()->register('user_signup_activated',
			[UserEvents::class, 'confirmed']);
	}

	if ($prefs['user_trigger_event'] === 'login') {
		e107::getEvent()->register('login', [UserEvents::class, 'login']);
	}
}
