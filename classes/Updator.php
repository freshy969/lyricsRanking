<?php

namespace Lubomir\LyricsRanking;


class Updator {
    private static $version;

    public function __construct() {
        $this->version = file_get_contents('version');
    }

    private static function getCurrentVersion() {
        $currentVersionUrl = "https://raw.githubusercontent.com/parallela/lyricsRanking/master/version";
        $currentVersion = file_get_contents($currentVersionUrl);

        return $currentVersion;
    }

    public static function checkForUpdate() {
        if(self::$version != self::getCurrentVersion()) 
            file_put_contents('latest.zip', fopen('https://github.com/parallela/lyricsRanking/archive/master.zip', 'r'));
            self::update();
    }

    public static function update() {
        if (file_exists('latest.zip'))
            shell_exec("unzip -o latest.zip");
    }
}