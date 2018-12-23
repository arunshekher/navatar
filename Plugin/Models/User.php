<?php

namespace Navatar\Plugin\Models;

class User
{

	public static function update($userId, $fileName)
	{
		$tp = \e107::getParser();
		$sql = \e107::getDb();

		// this is paranoia
		$userId = $tp->toDB($userId);

		$query =
			"UPDATE `#user` SET user_image = '-upload-{$fileName}' WHERE user_image = '' AND user_id={$userId}";

		return $sql->fetch($sql->gen($query));
	}
}