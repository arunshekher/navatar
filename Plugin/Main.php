<?php

namespace Navatar\Plugin;

abstract class Main
{
	/**
	 * Performs debug logging by writing a log file to the plugin directory
	 * @todo Change the log saving to e_LOG directory if there is something similar
	 * @param string|array $content
	 *  The data to be logged - can be passed as string or array.
	 * @param string $logname
	 *  The name of log that need to be written to file-system.
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