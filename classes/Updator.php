<?php

namespace Lubomir\LyricsRanking;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class Updator {
    private static $version = LyricsRanking_VER;

    private static function getCurrentVersion() {
        $currentVersionUrl = "https://gist.githubusercontent.com/parallela/1e76880158a10343b9734233f6411c12/raw/bae2b7ea78acf273449add08f18f2ae6a44573e1/lyricsRanking.version";
        $currentVersion = file_get_contents($currentVersionUrl);

        return $currentVersion;
    }

    public static function checkForUpdate() {
        if(self::$version != self::getCurrentVersion()) 
            file_put_contents(plugin_dir_path(__DIR__).'latest.zip', fopen('https://github.com/parallela/lyricsRanking/archive/master.zip', 'r'));
            if(file_exists(plugin_dir_path(__DIR__).'latest.zip'))
                self::update();

    }

    public static function update() {
        $zip = new ZipArchive;
        $read = $zip->open(plugin_dir_path(__DIR__).'latest.zip');

        if($read === true) {
            $zip->extractTo(plugin_dir_path(__DIR__));
            $zip->close();
            shell_exec("mv ".plugin_dir_path(__DIR__)."lyricsRanking-master/{,.[^.]}*"." ".plugin_dir_path(__DIR__));
            unlink(plugin_dir_path(__DIR__).'latest.zip');
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