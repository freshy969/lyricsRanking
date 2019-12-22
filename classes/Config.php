<?php
namespace Lubomir\LyricsRanking;

class Config {
    public function __construct()
    {
        /**
         * Set HTML template directory
         */
        PageRender::setDirectory( '/html/' );
    }
}