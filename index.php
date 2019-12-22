<?php
/*
Plugin Name: Lyrics Ranking
Plugin URI: https://ranking.lyrics.bg
Description: Custom plugin for ranking made for lyrics.bg
Author: Lubomir Stankov
Version: 1.0.15
Author URI: https://lstankov.me/
*/
!defined('LyricsRanking_VER') ? define('LyricsRanking_VER','1.0.15') : LyricsRanking_VER;


/*
 * Composer autoloader
 */
require 'vendor/autoload.php';

use Lubomir\LyricsRanking\App;

/*
 * Run the plugin
 */

App::run();

function plugin_activate()
{
    App::addData();
}
register_activation_hook(__FILE__, 'plugin_activate');


/*
 * Deactivation
 */
function plugin_disable()
{
    App::disable();
}
register_deactivation_hook(__FILE__, 'plugin_disable');
