<?php
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

	protected $initialText;
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