<?php

namespace Navatar\Plugin\Controllers;

use Navatar\Plugin\Models\User;

class Users extends Base
{
	public static function real($userId)
	{
		return User::real($userId); // todo: rename User model method to User::findRealNameById($userId)
	}
}