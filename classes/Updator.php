<?php

namespace Lubomir\LyricsRanking;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class Updator {
    private static $version = LyricsRanking_VER;
    private static $zip_file;
    private static $latest_plugin_dir;
    private static $plugin_dir;

    public function __construct()
    {
        self::$zip_file = plugin_dir_path(__DIR__)."latest.zip";
        self::$latest_plugin_dir = plugin_dir_path(__DIR__)."lyricsRanking-master/{,.[^.]}*";
        self::$plugin_dir = plugin_dir_path(__DIR__); 
    }

    private static function getCurrentVersion() {
        $currentVersionUrl = "https://gist.githubusercontent.com/parallela/1e76880158a10343b9734233f6411c12/raw/bae2b7ea78acf273449add08f18f2ae6a44573e1/lyricsRanking.version";
        $currentVersion = file_get_contents($currentVersionUrl);

        return $currentVersion;
    }

    public static function checkForUpdate() {
        if(self::$version != self::getCurrentVersion()) 
            file_put_contents(self::$zip_file, fopen('https://github.com/parallela/lyricsRanking/archive/master.zip', 'r'));
            if(file_exists(self::$zip_file))
                self::update();

    }

    public static function update() {
        $zip = new ZipArchive;
        $read = $zip->open(self::$zip_file);

        if($read === true) {
            $zip->extractTo(self::$plugin_dir);
            $zip->close();
            shell_exec("mv ".self::$latest_plugin_dir." ".self::$plugin_dir);
            unlink(self::$zip_file);
            self::rmdir_recursive(plugin_dir_path(__DIR__)."lyricsRanking-master");
        } else {
            return false;
        }
    }

    public static function rmdir_recursive($dir) {
        $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach($it as $file) {
            if ($file->isDir()) rmdir($file->getPathname());
            else unlink($file->getPathname());
        }
        rmdir($dir);
    }
}