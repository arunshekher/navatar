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
		Main::log($data, 'createNavatar-data');

		$userId = (int)$data['user_id'];
		$fileName = $this->generateFileName($data);
		$path = $this->getPath($fileName);


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
		Main::log($data, 'generateNavatar-data');

		// todo: if Navatar with username | real name (Admin Option) call db with user_id
		//  to get Real Name
		// todo: Add font color, font variant etc - should it be class properties?

		$namatarSize = ''; // todo: create admin prefernce for namatar size
		$characterLength = $this->prefs['character_length'];
		$fontSize = $this->prefs['font_size'];
		$fontColor = trim($this->prefs['font_color']);
		$backgroundColor = Color::random();
		$fontVariant = '/fonts/OpenSans-Semibold.ttf';
		$driver = '';

		Main::log($backgroundColor, 'bankground-color-gererate-nava');

		/** @var TYPE_NAME $e */
		try {
			$avatar = new InitialAvatar();

			$avatar->name($data['user_name'])->length(1)->fontSize(0.5)
				->size(350)->background('#333')->color('#fff')
				->generate()->save($path, 100);

		}
		catch (\Exception $e) {
			Main::log($e, 'navatar-generate-error');
			Main::log($e->getMessage(), 'initial-avatar-generate-error', \e_LOG);
		}


	}


	public static function removeAll()
	{
		$controller = static::instantiate();
		return $controller->removeImages();
	}


	/**
	 * Removes all navatar images (detected with '*_navatar.png' wildcard)
	 *  under e_AVATAR_UPLOAD path.
	 * @return array
	 */
	protected function removeImages()
	{
		$unlinkStatus = [];
		//$unlinkFail = [];

		foreach (glob(e_AVATAR_UPLOAD . '*_navatar.png') as $filename) {

			if(is_file($filename) && @unlink($filename)){
				// delete success
				$unlinkStatus['success'][] = $filename;
			} else if (is_file ($filename)) {
				// unlink failed.
				// you would have got an error if it wasn't suppressed
				$unlinkStatus['fail'][] = $filename;
			} else {
				// file doesn't exist
			}

//			if (file_exists($filename)) {
//				unlink($filename);
//				continue;
//			}
//			$unlinkFail[$filename];
		}
		//return $unlinkFail;
		return $unlinkStatus;
	}

}
