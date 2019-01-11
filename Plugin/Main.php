<?php

namespace Navatar\Plugin;

abstract class Main
{
	/**
	 * @var instances[] reference to *Singleton* instances of any child
	 *     class.
	 */
	protected static $instances = [];
	/**
	 * Navatar preferences
	 *
	 * @var array
	 */
	protected $prefs;


	/**
	 * Main constructor.
	 *
	 */
	public function __construct()
	{
		$this->init(\e107::getPlugPref('navatar'));
	}


	/**
	 * Initializes Navatar\Plugin\Main class
	 *
	 * @param $prefs
	 */
	protected function init($prefs)
	{
		$colorsArray =
			$this->delimitedStringToArray($prefs['background_colors']);
		unset($prefs['background_colors']);
		$prefs['background_colors'] = $colorsArray;

		$this->setPrefs($prefs);
	}


	/**
	 * Returns the *Singleton* instance of the called class.
	 *
	 * @return static The *Singleton* instance.
	 */
	protected static function instantiate()
	{
		if ( ! isset(self::$instances[static::class])) {

			self::$instances[static::class] = new static();

		}

		return self::$instances[static::class];
	}


	/**
	 * Converts non-printing character delimited string to numeric array
	 *
	 * @param $inputString
	 *
	 * @return array[]|false|string[]
	 */
	protected function delimitedStringToArray($inputString)
	{
		return preg_split("/[\s]+/", $inputString);
	}


	/**
	 * Writes passed in data to a log file
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
		$date = date('l jS \of F Y h:i:s A');
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

		file_put_contents($path . $logName . '.log',
			' --- ' . $date . ' --- ' . PHP_EOL . $content . PHP_EOL,
			FILE_APPEND);
	}


	/**
	 * Gets preference
	 *
	 * @return array
	 */
	public function getPrefs()
	{
		return $this->prefs;
	}


	/**
	 * Sets preference
	 *
	 * @param array $prefs
	 *
	 * @return \Navatar\Plugin\Main
	 */
	protected function setPrefs($prefs)
	{
		$this->prefs = $prefs;

		return $this;
	}
}