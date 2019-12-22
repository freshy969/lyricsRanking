<?php

namespace Lubomir\LyricsRanking;

use Lubomir\LyricsRanking\DatabaseSeeder;
use Lubomir\LyricsRanking\Updator;

class App
{

	public static function run()
	{
		/*
		* Plugin version control
		*/
		
		/*
		 * Run database seeder
		 */
		$databaseSeeder = new DatabaseSeeder();
		$databaseSeeder->runner();


		/*
		 * Make instance of the plugin
		 */
		new Plugin();

		/*
		 * Check for updates
		 */
		Updator::checkForUpdate();
	}

	public static function disable()
	{
		/*
		 * Drop the tables
		 */
		$databaseSeeder = new DatabaseSeeder();
		$databaseSeeder->drop();
	}

	public static function addData()
	{
		/*
		 * Add some example records to database
		 */
		$databaseSeeder = new DatabaseSeeder();
		$databaseSeeder->seed();
	}
}
