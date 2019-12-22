<?php

namespace Lubomir\LyricsRanking;

use Lubomir\LyricsRanking\PageRender;

class Plugin {

	public function __construct() {
		PageRender::setDirectory( '/html/' );

		/*
		 * Actions
		 */
		add_action( 'admin_menu', array( $this, 'admin_menu_register' ) );
		add_action( 'admin_register', array( $this, 'admin_menu_register' ) );
		add_action('version_check', array($this, 'version'));
		add_shortcode( 'top_users', array( $this, 'ranking' ) );

	}

	public function admin_menu_register() {
		add_menu_page( 'Lyrics Ranking', 'Lyrics Ranking', 'manage_options', 'lyrics_ranking.php', array(
			$this,
			'admin_menu'
		), 'https://cdn.lyrics.bg/img/ranking_icon.png' );
		add_submenu_page( 'lyrics_ranking.php', 'Add Rank', 'Add rank', 'manage_options', 'lyrics_ranking_add.php', array(
			$this,
			'add_rank_admin_menu'
		) );
	}

	public function admin_menu() {
		PageRender::Page( "main" );
	}

	public function add_rank_admin_menu() {
		PageRender::Page( "add" );
	}

	public function ranking( $atts, $content = null ) {
		ob_start();
		PageRender::Page( "ranking" );
		$content = ob_get_clean();

		return $content;
	}
	// TODO
	public function version() {

	}


}