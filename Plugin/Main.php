<?php

namespace Navatar\Plugin;

abstract class Main
{
	/**
	 * Navatar preferences
	 *
	 * @var array
	 */
	protected $prefs;


	/**
	 * Main constructor.
	 *
	 * @param $prefs
	 */
	public function __construct()
	{
		$this->init(\e107::getPlugPref('navatar'));
	}


	protected function init($prefs)
	{
		$colorsArray = $this->delimitedStringToArray($prefs['background_colors']);
		unset($prefs['background_colors']);
		$prefs['background_colors'] = $colorsArray;

		$this->setPrefs($prefs);
		//debug
		//Main::log($this->prefs, 'main-class-prefs');
	}

	/**
	 * @param array $prefs
	 *
	 * @return Main
	 */
	public function setPrefs($prefs)
	{
		$this->prefs = $prefs;

		return $this;
	}


	/**
	 * Writes passed in data to a log file to the 'logs'
	 *  directory inside plugin directory.
	 *
	 * @param mixed  $content
	 *  The data to be logged.
	 * @param string $logName
	 *  Name the log file that need to be written to file-system.
	 * @param string $location
	 */
	public static function log(
		$content, $logName = 'navatar-log', $location = \e_PLUGIN
	) {
		if ($location === \e_PLUGIN) {
			$path = $location . 'navatar/logs/';
		} else {
			$path = $location . 'navatar/';
		}

		if ( ! file_exists($path)) {
			mkdir($path, 0777, true);
		}

		if (is_array($content) || is_object($content)) {
			$content = var_export($content, true);
		}

		file_put_contents($path . $logName . '.log', $content . PHP_EOL,
			FILE_APPEND);
	}


	/**
	 * Converts unprintable character delimited string to numeric array
	 *
	 * @param $inputString
	 *
	 * @return array[]|false|string[]
	 */
	protected function delimitedStringToArray($inputString)
	{
		return preg_split("/[\s]+/", $inputString);
	}
}