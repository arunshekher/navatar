<?php

use Navatar\Plugin\Listeners\UserEvents;

if ( ! defined('e107_INIT')) {
	exit;
}
require_once __DIR__ . '/vendor/autoload.php';

$prefs = e107::getPlugPref('navatar');


if($prefs['user_trigger_event'] === 3) {
	e107::getEvent()->register('user_signup_activated', [UserEvents::class, 'confirmed']);
	e107::getEvent()->register('login', [UserEvents::class, 'login']);
}

if ($prefs['user_trigger_event'] === 2) {
	e107::getEvent()->register('user_signup_activated', [UserEvents::class, 'confirmed']);
}

if ($prefs['user_trigger_event'] === 1) {
	e107::getEvent()->register('login', [UserEvents::class, 'login']);
}

//\Navatar\Plugin\Main::log($prefs, 'emodule-prefs');