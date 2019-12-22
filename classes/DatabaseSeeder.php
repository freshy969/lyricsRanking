<?php

namespace Lubomir\LyricsRanking;
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


class DatabaseSeeder {
	private $wpdb, $table_prefix, $charset_collate;

	public function __construct() {
		global $wpdb;
		$this->wpdb         = &$wpdb;
		$this->table_prefix = $this->wpdb->prefix . 'ranks';
		$charset_collate    = $this->wpdb->get_charset_collate();

	}

	public function runner() {
		$table = $this->table_prefix;
		$sql   = "CREATE TABLE IF NOT EXISTS $table ( 
    id int(11) NOT NULL AUTO_INCREMENT,
    rank_title VARCHAR(50) NOT NULL,
    image_url VARCHAR(50) NOT NULL,
    post_needed int NOT NULL,
    PRIMARY KEY  (id)
    ) $this->charset_collate;";
		dbDelta( $sql );
	}

	public function seed() {
		$table = $this->table_prefix;

		$checkForExistingData = $this->wpdb->get_results("SELECT * FROM {$table}ranks");
		if($checkForExistingData == null) {
			$query = "INSERT INTO $table (rank_title,image_url,post_needed) VALUES 
			('Noob','http://placehold.it/64x64',10),('Beginner','http://placehold.it/64x64',20),('Expert','http://placehold.it/64x64',30);
			";
			$this->wpdb->query( $query );
		}
	}

	public function drop() {
		$table = $this->table_prefix;
		$this->wpdb->query( "DROP TABLE $table" );
	}


}