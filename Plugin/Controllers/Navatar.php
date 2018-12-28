<?php

namespace Navatar\Plugin\Controllers;

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Navatar\Plugin\Main;
use Navatar\Plugin\Models\User;

class Navatar extends Base
{

	public static function assign($data)
	{
		$controller = static::instantiate();

		return $controller->assignNavatar($data);
	}


	/**
	 * @param $data
	 *
	 * @return array|bool
	 */
	public function assignNavatar($data)
	{
		$userId = (int)$data['user_id'];
		$fileName = $this->generateFileName($data);
		$path = $this->getPath($fileName);

		if (User::fit($userId) /*&& ! file_exists($path)*/) {

			//clear image cache
			//\e107::getCache()->clearAll('image', '.*(\.cache\.bin)');
			\e107::getCache()->clearAll('browser');

			// call navatar generation method
			$this->generateNavatar($data, $path);

			// database update
			return User::update($userId, $fileName);
		}

		return false;
	}


	/**
	 * Generates Navatar filename
	 *
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
	 * Gets Navatar save path.
	 *
	 * @param $fileName
	 *
	 * @return string
	 */
	public function getPath($fileName)
	{
		return e_AVATAR_UPLOAD . $fileName;
	}


	/**
	 * Generates Navatar image
	 *
	 * @param $data
	 * @param $path
	 */
	public function generateNavatar($data, $path)
	{


		$userName = $this->resolveNameSource($data);

		// todo: ? should these vars be class properties than local vars
		$namatarSize = trim($this->prefs['navatar_size']);
		$characterLength = trim($this->prefs['character_length']);
		$fontSize = trim($this->prefs['font_size']);
		$fontColor = trim($this->prefs['font_color']);
		$backgroundColor = Color::random();
		$fontVariant = trim($this->prefs['font_variant']);
		$driver = trim($this->prefs['php_graphics_lib']);
		$quality = trim($this->prefs['navatar_quality']);

		Main::log($fontVariant, 'font-variant-test');

		/**  */
		try {
			$avatar = new InitialAvatar();

			$avatar->name($userName)->length($characterLength)
				->font($fontVariant)->fontSize($fontSize)->size($namatarSize)
				->background($backgroundColor)->color($fontColor)->$driver()
				->generate()->save($path, $quality);

		}
		catch (\Exception $e) {
			Main::log($e->getMessage() . ' ' . $e->getTrace(),
				'initial-avatar-generate-error', \e_LOG);
		}

	}


	/**
	 * @param $data
	 *
	 * @return int
	 */
	private function resolveNameSource($data)
	{
		if ($this->prefs['initials_source'] === 'realname') {
			return $this->getRealName($data);
		}

		return $data['user_name'];
	}


	/**
	 * Gets users real name from user table if no
	 *  realname returns username
	 *
	 * @param $data
	 *
	 * @return int
	 */
	public function getRealName($data)
	{
		$name = User::real($data['user_id']);

		return $name ?: $data['user_name'];
	}


	/**
	 * Public static alias for
	 * \Navatar\Plugin\Controllers\Navatar::removeImages()
	 *
	 * @return array
	 */
	public static function removeAll()
	{
		$controller = static::instantiate();

		return $controller->removeImages();
	}


	/**
	 * Removes all navatar images (detected with '*_navatar.png' wildcard)
	 *  under e_AVATAR_UPLOAD path.
	 *
	 * @return array
	 */
	protected function removeImages()
	{
		$unlinkStatus = [];

		foreach (glob(e_AVATAR_UPLOAD . '*_navatar.png') as $filename) {

			if (is_file($filename) && @unlink($filename)) {
				// delete success
				$unlinkStatus['success'][] = $filename;
			} else if (is_file($filename)) {
				// unlink failed.
				$unlinkStatus['fail'][] = $filename;
			} else {
				// file doesn't exist
				$unlinkStatus['desist'][] = $filename;
			}

		}

		return $unlinkStatus;
	}

}
