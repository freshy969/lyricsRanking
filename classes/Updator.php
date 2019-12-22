<?php

namespace Lubomir\LyricsRanking;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

/**
 * Custom plugin update
 */
class Updator {
    private static $version = LyricsRanking_VER;
    private static $dirs = array();

    public static function setDirs()
    {
        self::$dirs = array(
            'zip'=>plugin_dir_path(__DIR__)."latest.zip",
            'latest_plugin_dir'=>plugin_dir_path(__DIR__)."lyricsRanking-master/{,.[^.]}*",
            'plugin_dir' => plugin_dir_path(__DIR__)
        );
    }

    private static function getCurrentVersion() {
        $currentVersionUrl = "https://gist.githubusercontent.com/parallela/1e76880158a10343b9734233f6411c12/raw/bae2b7ea78acf273449add08f18f2ae6a44573e1/lyricsRanking.version";
        $currentVersion = file_get_contents($currentVersionUrl);

        return $currentVersion;
    }

    public static function checkForUpdate() {
        if(self::$version != self::getCurrentVersion())
            self::setDirs();
            file_put_contents(self::$dirs['zip'], fopen('https://github.com/parallela/lyricsRanking/archive/master.zip', 'r'));
            if(file_exists(self::$dirs['zip']))
                self::update();

    }

    public static function update() {
        $zip = new ZipArchive;
        $read = $zip->open(self::$dirs['zip']);

        if($read === true) {
            $zip->extractTo(self::$dirs['plugin_dir']);
            $zip->close();
            rename(self::$dirs['latest_plugin_dir'],self::$dirs['plugin_dir']);
            unlink(self::$dirs['zip']);
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