<?php

namespace Navatar\Plugin\Models;

class User
{

	public static function update($userId, $fileName)
	{
		$tp = \e107::getParser();
		$sql = \e107::getDb();

		$userId = $tp->toDB($userId);

		$query =
			"UPDATE `#user` SET user_image = '-upload-{$fileName}' WHERE user_image = '' AND user_id={$userId}";

		return $sql->fetch($sql->gen($query));
	}


	public static function fit($userId)
	{
		$tp = \e107::getParser();
		$sql = \e107::getDb();

		$userId = $tp->toDB($userId);

		return $sql->select('user', 'user_id, user_image',
			"user_id = {$userId} AND user_image = ''");
	}


	public static function rollback()
	{
		$sql = \e107::getDb();
		return $sql->update('user', ['user_image' => '', 'WHERE' => "user_image LIKE '%_navatar.png'"]);
	}


	public static function count()
	{
		$sql = \e107::getDb();
		return $sql->count('user', '(*)', "WHERE user_image LIKE '%_navatar.png'");
	}
}