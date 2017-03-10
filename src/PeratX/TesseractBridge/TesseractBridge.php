<?php

/**
 * TesseractBridge
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author iTXTech
 * @website https://itxtech.org
 */

namespace PeratX\TesseractBridge;

use iTXTech\SimpleFramework\Module\Module;
use iTXTech\SimpleFramework\Util\Config;

class TesseractBridge extends Module{

	private static $tesseractExecutable;
	private static $outputFile;

	public function load(){
		@mkdir($this->getDataFolder());
		$config = new Config($this->getDataFolder() . "config.yml", Config::YAML, ["tesseract-executable" => "tesseract"]);
		self::$tesseractExecutable = $config->get("tesseract-executable", "tesseract");
		self::$outputFile = $this->getDataFolder() . "out";
	}

	public function unload(){
		@unlink(self::$outputFile . ".txt");
	}

	/**
	 * Read specified image. -l options is recommended.
	 * 
	 * @param string $file
	 * @param string $options
	 * @return string
	 */
	public static function readImage(string $file, string $options = "") : string{
		@unlink(self::$outputFile . ".txt");
		exec(self::$tesseractExecutable . " " . $file . " " . self::$outputFile . ($options == "") ? : " " . $options);
		if(file_exists(self::$outputFile . ".txt")){
			return @file_get_contents(self::$outputFile . ".txt");
		}
		return "";
	}
}