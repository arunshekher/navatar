<?php

namespace Navatar\Plugin\Controllers;

use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Navatar\Plugin\Main;
use Navatar\Plugin\Models\User;

class Navatar extends Base
{

	/**
	 * Assigns navatars per user - Public static alias for
	 * Navatar\Plugin\Controllers\Navatar::assignNavatar()
	 *
	 * @param $data
	 *
	 * @return array|bool
	 */
	public static function assign($data)
	{
		$controller = static::instantiate();

		return $controller->assignNavatar($data);
	}


	/**
	 * Assigns navatars per user
	 *
	 * @param $data
	 *
	 * @return array|bool
	 */
	public function assignNavatar($data)
	{
		$this->initializeNavatar($data);

		// debug
		Main::log(self::$instances, 'instances-from-assign-navatar');

		if (User::fit($this->userId) /*&& ! file_exists($path)*/) {

			//clear image cache
			//\e107::getCache()->clearAll('image', '.*(\.cache\.bin)');
			\e107::getCache()->clearAll('browser');

			// call navatar generation method
			$this->generateNavatar();

			// database update
			return User::update($this->userId, $this->fileName);
		}

		return false;
	}


	/**
	 * Initializes Navatar\Plugin\Controllers\Navatar object
	 *
	 * @param $data
	 */
	protected function initializeNavatar($data)
	{
		$this->setUserId($data['user_id'])->setUserName($data['user_name'])
			->setFileName($this->generateFileName($this->userId))
			->setInitialText($this->resolveInitialsSource())
			->setCharLength($this->prefs['character_length'])
			->setFontSize($this->prefs['font_size'])
			->setFontColor($this->prefs['font_color'])
			->setFontVariant($this->prefs['font_variant'])
			->setBackgroundColor($this->determineBgColor())
			->setDriver($this->prefs['php_graphics_lib'])
			->setImageSize($this->prefs['navatar_size'])
			->setSavePath($this->conjureSavePath())
			->setImageQuality($this->prefs['navatar_quality']);
	}


	private function setImageQuality($imageQuality)
	{
		$this->imageQuality = $imageQuality;

		return $this;
	}


	private function setImageSize($imageSize)
	{
		$this->imageSize = $imageSize;

		return $this;
	}


	private function setDriver($driver)
	{
		$this->driver = $driver;

		return $this;
	}


	private function setBackgroundColor($bgColor)
	{
		$this->bgColor = $bgColor;

		return $this;
	}


	private function setFontVariant($fontVariant)
	{
		$this->fontVariant = $fontVariant;

		return $this;
	}


	private function setFontColor($fontColor)
	{
		$this->fontColor = $fontColor;

		return $this;
	}


	private function setFontSize($fontSize)
	{
		$this->fontSize = $fontSize;

		return $this;
	}


	protected function setCharLength($charLength)
	{
		$this->charLength = $charLength;

		return $this;
	}


	private function setInitialText($initialText)
	{
		$this->initialText = $initialText;

		return $this;
	}


	private function setFileName($fileName)
	{
		$this->fileName = $fileName;

		return $this;
	}


	protected function setUserName($userName)
	{
		$this->userName = $userName;

		return $this;
	}


	protected function setUserId($userId)
	{
		$this->userId = $userId;

		return $this;
	}


	private function setSavePath($savePath)
	{
		$this->savePath = $savePath;
		return $this;
	}


	/**
	 * Generates Navatar filename
	 *
	 * @param $userId
	 *
	 * @return string
	 */
	public function generateFileName($userId)
	{
		$fileName = 'ap_' . \e107::getParser()
				->leadingZeros($userId, 7) . '_navatar.png';

		return $fileName;
	}


	/**
	 * @param $data
	 *
	 * @return int
	 */
	private function resolveInitialsSource()
	{
		if ($this->prefs['initials_source'] === 'realname') {
			return $this->findRealName($this->userId);
		}

		return $this->userName;
	}


	/**
	 * Gets user's Real Name (user_login) from database user table; if fails to
	 * return user_login returns user_name
	 *
	 * @param $userId
	 *
	 * @return int
	 */
	public function findRealName($userId)
	{
		$name = User::real($userId);

		return $name ?: $this->userName;
	}


	/**
	 * Resolves background color based on admin preference
	 *
	 * @return mixed|string
	 */
	private function determineBgColor()
	{
		if ($this->prefs['random_bg_color']) {
			return Color::random();
		}

		return array_shift($this->prefs['background_colors']);
	}


	/**
	 * Generates Navatar image
	 *
	 * @param $data
	 * @param $path
	 */
	public function generateNavatar()
	{

		/**  */
		try {
			$avatar = new InitialAvatar();

			$avatar->name($this->initialText)->length($this->charLength)
				->font($this->fontVariant)->fontSize($this->fontSize)
				->size($this->imageSize)->background($this->bgColor)
				->color($this->fontColor)->{$this->driver}()->generate()
				->save($this->savePath, $this->imageQuality);

		}
		catch (\Exception $e) {
			Main::log($e, 'initial-avatar-generate-error', \e_LOG);
			// todo: on failure e-mail admin & write to admin log
		}

	}


	/**
	 * Returns navatar save path.
	 *
	 * @param $fileName
	 *
	 * @return string
	 */
	public function conjureSavePath()
	{
		return e_AVATAR_UPLOAD . $this->fileName;
	}


}
