<?php

namespace Lubomir\LyricsRanking;


class PageRender {
	protected static $directory;

	public static function setDirectory($dirname) {
		self::$directory = $dirname;
	}

	public static function getDirectory() {
		return plugin_dir_path(__DIR__).stripslashes(str_replace('/','',self::$directory));
	}

	public static function Page($filename) {
		$file = self::getDirectory().DIRECTORY_SEPARATOR.$filename.'.template.php';
		include ($file);
	}

}