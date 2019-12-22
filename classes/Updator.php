<?php

namespace Lubomir\LyricsRanking;


class Updator {
    private static $version;

    public function __construct() {
        $this->version = file_get_contents(plugin_dir_path(__DIR__).'version');
    }

    private static function getCurrentVersion() {
        $currentVersionUrl = "https://gist.githubusercontent.com/parallela/1e76880158a10343b9734233f6411c12/raw/bae2b7ea78acf273449add08f18f2ae6a44573e1/lyricsRanking.version";
        $currentVersion = file_get_contents($currentVersionUrl);

        return $currentVersion;
    }

    public static function checkForUpdate() {
        if(self::$version != self::getCurrentVersion()) 
            file_put_contents(plugin_dir_path(__DIR__).'latest.zip', fopen('https://github.com/parallela/lyricsRanking/archive/master.zip', 'r'));
            self::update();
    }

    public static function update() {
        if (file_exists('latest.zip'))
            shell_exec("unzip -o ".plugin_dir_path(__DIR__).'latest.zip');
            shell_exec("mv ".plugin_dir_path(__DIR__).'lyricsRanking-master/*'. " " . plugin_dir_path(__DIR__) );
            file_put_contents(plugin_dir_path(__DIR__).'version',"");
            file_put_contents(plugin_dir_path(__DIR__).'version',self::getCurrentVersion());
            unlink(plugin_dir_path(__DIR__).'latest.zip');
    }
}