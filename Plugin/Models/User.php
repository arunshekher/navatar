<?php

namespace Navatar\Plugin\Models;

class User
{

	public static function update($userId, $fileName)
	{
		//@todo sanitize variables for sql
		$sql = \e107::getDb();
		$query =
			"UPDATE `#user` SET user_image = '-upload-{$fileName}' WHERE user_image = '' AND user_id={$userId}";

		return $sql->fetch($sql->gen($query));
	}
}