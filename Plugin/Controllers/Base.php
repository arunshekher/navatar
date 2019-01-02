<?php
/**
 * This file is part of e107dev.box distribution.
 * Copyright (c) 2016-2018, Arun S. Sekher.
 *
 * @category   Plugins
 * @package    Copyright
 * @version    1.0.0
 * @since      1.0.0
 * @author     Arun S. Sekher <arunshekher@hotmail.com>
 * @see        {@link http://github.com/shapeshed/copyright.ee_addon/}
 * @license    {@link http://www.gnu.org/licenses/}
 *
 */

namespace Navatar\Plugin\Controllers;

use Navatar\Plugin\Main;

abstract class Base extends Main
{

	protected $userId;
	protected $userName;
	protected $bgColor;
	protected $charLength;
	protected $fontVariant;
	protected $fontColor;
	protected $fontSize;
	protected $driver;
	protected $imageSize;
	protected $imageQuality;

	protected $initialSource;
	protected $fileName;
	protected $savePath;



//	public static function __callStatic($name, $arguments)
//	{
//		$class = static::instantiate();
//
//		if (method_exists($class, $name)) {
//
//			return $class->$name(implode(',', $arguments));
//          return  call_user_func_array([static::class, $name], $arguments);
//
//		}
//		return false;
//	}

}