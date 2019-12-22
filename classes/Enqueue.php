<?php
namespace Lubomir\LyricsRanking;

class  Enqueue {
	/* 
	 * Page scripts
	 */
	public function __construct() {
		wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
		wp_enqueue_script(array('jquery'));
		wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js');
	}

}