<?php
/*
Plugin Name: Lyrics Ranking
Plugin URI: https://ranking.lyrics.bg
Description: Custom plugin for ranking made for lyrics.bg
Author: Lubomir Stankov
Version: 1.1.2
Author URI: https://lstankov.me/
*/

/*
 * Composer autoloader
 */
require 'vendor/autoload.php';

/** 
 * 
 * Update checker
 * 
 */
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/parallela/lyricsRanking',
	__FILE__,
	'lyrics-ranking'
);
$myUpdateChecker->setBranch('master');

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
