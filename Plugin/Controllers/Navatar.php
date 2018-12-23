<?php

namespace Navatar\Plugin\Controllers;


use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Navatar\Plugin\Main;
use Navatar\Plugin\Models\User;

class Navatar extends Base
{

	public static function create($data)
	{
		$controller = static::instantiate();
		return $controller->createNavatar($data);
	}

	/**
	 * @param $data
	 *
	 * @return array|bool
	 */
	public function createNavatar($data)
	{
		// todo: if Navatar with user real name (Admin Option) call db with user_id

		$fileName = 'ap_' . \e107::getParser()
				->leadingZeros($data['user_id'], 7) . '_navatar.png';
		$path = e_AVATAR_UPLOAD . $fileName;

		if ( ! file_exists($path)) {

			$avatar = new InitialAvatar();

			$avatar->name($data['user_name'])->length(2)->fontSize(0.5)->size(250)
				->background(Color::random())->color('#fff')->generate()
				->save($path, 100);

			//clear thumbnail cache
			\e107::getCache()->clearAll('image');

			// sql
			$userId = (int)$data['user_id'];

			return User::update($userId, $fileName);
		}

		return false;
	}


	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function generateFilename($data)
	{
		$filename = 'ap_' . \e107::getParser()
				->leadingZeros($data['user_id'], 7) . '_navatar.png';

		return $filename;
	}


	/**
	 * @param $filename
	 *
	 * @return string
	 */
	public function getPath($filename)
	{
		return e_AVATAR_UPLOAD . $filename;
	}


	/**
	 * @param $data
	 * @param $path
	 */
	public function generateNavatar($data, $path)
	{
		$avatar = new InitialAvatar();

		$avatar->name($data['user_name'])->length(2)->fontSize(0.6)->size(350)
			->background('#fb6277')->color('#fff')->generate()
			->save($path, 100);
	}


	/**
	 * @param $data
	 * @param $filename
	 *
	 * @return array
	 */
	public static function updateUserRecord($data, $filename)
	{
		$userId = (int)$data['user_id'];

		//@todo sanitize variables for sql
		$sql = \e107::getDb();
		$query =
			//"UPDATE `#user` SET user_image = '-upload-{$filename}' WHERE LENGTH(user_image) = 0 AND user_id={$data['user_id']}";
			"UPDATE `#user` SET user_image = '-upload-{$filename}' WHERE user_image = '' AND user_id={$userId}";

		return $sql->fetch($sql->gen($query));
	}
}