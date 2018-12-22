<?php

use Navatar\Plugin\Listeners\UserEvents;

if ( ! defined('e107_INIT')) {
	exit;
}
require_once __DIR__ . '/vendor/autoload.php';

// signup activated event trigger
e107::getEvent()->register('user_signup_activated', [UserEvents::class, 'confirmed']);

// user login event trigger
e107::getEvent()->register('login', [UserEvents::class, 'login']);