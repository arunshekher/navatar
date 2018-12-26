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

		$userId = (int)$data['user_id'];
		$fileName = $this->generateFileName($data);
		$path = $this->getPath($fileName);

		//Main::log(User::get($userId), 'user-with-no-avatar');

		if (User::fit($userId) /*&& ! file_exists($path)*/) {

			//clear thumbnail cache
			\e107::getCache()->clearAll('image');

			// call navatar generation method
			$this->generateNavatar($data, $path);

			// database update
			return User::update($userId, $fileName);
		}
		return false;
	}


	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function generateFileName($data)
	{
		$fileName = 'ap_' . \e107::getParser()
				->leadingZeros($data['user_id'], 7) . '_navatar.png';

		return $fileName;
	}


	/**
	 * @param $fileName
	 *
	 * @return string
	 */
	public function getPath($fileName)
	{
		return e_AVATAR_UPLOAD . $fileName;
	}


	/**
	 * @param $data
	 * @param $path
	 */
	public function generateNavatar($data, $path)
	{
		// todo: if Navatar with username | real name (Admin Option) call db with user_id
		// todo: font color, font variant...
		$avatar = new InitialAvatar();

		/** @var TYPE_NAME $e */
		try {

			$avatar->name($data['user_name'])
				->length(2)
				->fontSize(0.5)
				->size(350)
				->background(Color::random())
				->color('#fff')
				->generate()
				->save($path, 100);

		} catch (\Exception $e) {
		    Main::log($e, 'generation-error');
		}


	}

}
