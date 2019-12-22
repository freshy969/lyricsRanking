<?php

namespace Lubomir\LyricsRanking;
/**
 * Plugin Helpers
 */
class Helpers {
	protected $wpdb;

	/**
	 * Helpers constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	/**
	 * @param $user_id
	 *
	 * @return array|object|void|null
	 */
	public function getUser( $user_id ) {

		$user = $this->wpdb->get_row( "SELECT * FROM {$this->wpdb->users} WHERE ID={$user_id}" );

		return $user;

	}

	public function getUsers() {
		$users = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->users}");

		return $users;
	}

	/**
	 * @return array|object|null
	 */
	public function getRanks() {
		$ranks = $this->wpdb->get_results( "SELECT * FROM {$this->wpdb->prefix}ranks" );
		usort($ranks, function($rank1,$rank2) {
			if ($rank1->post_needed == $rank2->post_needed) return 0;
			return $rank1->post_needed < $rank2->post_needed ? -1 : 1;
		});

		return $ranks;
	}

	/**
	 * @param $user_id
	 *
	 * @return bool
	 */
	public function getCurrentRankOfUser($user_id) {
		$currentRank = false;

		$ranks = $this->getRanks();
		$user = $this->wpdb->get_row( "SELECT * FROM {$this->wpdb->users} WHERE ID={$user_id}" );
		$posts_count = count_user_posts($user->ID, 'lyrics');

		foreach($ranks as $rank) {
			if($posts_count <= $rank->post_needed) {
				$currentRank = $rank;
				break;
			}
		}
		if(false === $currentRank) {
			$currentRank = $rank;
		}

		return $currentRank;

	}

	/**
	 * @param $rank_title
	 * @param $image_url
	 * @param $post_needed
	 *
	 * @return bool
	 */
	public function createNewRank($rank_title,$image_url,$post_needed) {

		$query = $this->wpdb->prepare("INSERT INTO {$this->wpdb->prefix}ranks (`rank_title`,`image_url`,`post_needed`) VALUES (%s,%s,%d)",$rank_title,$image_url,$post_needed);
		$this->wpdb->query($query);

		return true;
	}

	/**
	 * @param $rank_id
	 *
	 * @return bool
	 */
	public function deleteRank($rank_id) {
		$query = $this->wpdb->prepare("DELETE FROM {$this->wpdb->prefix}ranks WHERE id=%d",$rank_id);
		$this->wpdb->query($query);

		return true;
	}

	public function updateRank($rank_id,$rank_title,$image_url,$post_needed) {

		$query = $this->wpdb->prepare("UPDATE {$this->wpdb->prefix}ranks SET rank_title=%s,image_url=%s,post_needed=%d WHERE id=%d",$rank_title,$image_url,$post_needed,$rank_id);
		$this->wpdb->query($query);

		return true;

	}

}