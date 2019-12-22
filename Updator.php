<?php

namespace Lubomir\LyricsRanking;


class Updator {
    private $version;

    public function __construct() {
        $this->version = LyricsRanking_VERSION;
    }

    private function getVersion() {
        $currentVersionUrl = "https://raw.githubusercontent.com/parallela/lyricsRanking/master/version";
        $currentVersion = file_get_contents($currentVersionUrl);


    }
}