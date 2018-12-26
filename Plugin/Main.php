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
	 * Background colors array
	 *
	 * @var array
	 */
	protected $bgColors;


	/**
	 * Main constructor.
	 *
	 * @param $prefs
	 */
	public function __construct()
	{
		$this->prefs = \e107::getPlugPref('navatar');
		$this->bgColors
			= $this->nlDelimStrToArray($this->prefs['background_colors']);
	}


	/**
	 * Converts newline delimited string to numeric array
	 *
	 * @param string $inputString
	 *
	 * @return array
	 */
	protected function nlDelimStrToArray($inputString)
	{
		$str = str_replace(["\r\n", "\n\r"], "|", $inputString);

		return explode("|", $str);
	}


	/**
	 * Writes passed in data to a log file to the 'logs'
	 *  directory inside plugin directory.
	 *
	 * @param mixed $content
	 *  The data to be logged.
	 * @param string $logName
	 *  Name the log file that need to be written to file-system.
	 */
	public static function log($content, $logName = 'navatar-log')
	{
		$path = \e_PLUGIN .'navatar/logs/';

		if (! file_exists($path)) {
			mkdir($path, 0777, true);
		}

		if (is_array($content) || is_object($content)) {
			$content = var_export($content, true);
		}

		file_put_contents($path . $logName . '.txt', $content . PHP_EOL, FILE_APPEND);
		unset($path, $content, $logName);
	}
}