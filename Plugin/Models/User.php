<?php

namespace Navatar\Plugin\Models;

class User
{


	public static function update($userId, $fileName)
	{
		$sql = \e107::getDb();
		return $sql->update('user', ['user_image' => "-upload-{$fileName}", 'WHERE' => "user_image = '' AND user_id = {$userId}"]);
	}


	public static function fit($userId)
	{
		$sql = \e107::getDb();
		return $sql->retrieve('user', 'user_id', "user_id = {$userId} AND user_image = '' ");
	}


	public static function rollback()
	{
		$sql = \e107::getDb();
		return $sql->update('user', ['user_image' => '', 'WHERE' => "user_image LIKE '%_navatar.png' "]);
	}


	public static function count()
	{
		$sql = \e107::getDb();
		return $sql->count('user', '(*)', "WHERE user_image LIKE '%_navatar.png' ");
	}



	public static function real($userId)
	{
		$sql = \e107::getDb();
		return $sql->retrieve('user','user_login',"user_id = {$userId} ");
	}
}