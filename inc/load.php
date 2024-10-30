<?php

/**
 * Plugin load class.
 *
 * @author   Völker Webdesign Studio
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! class_exists( 'LP_Addon_ContentForMultipleCourses' ) ) {

	class LP_Addon_ContentForMultipleCourses extends LP_Addon {

		/**
		 * @var string
		 */
		protected $_tab_slug = '';

		/**
		 * @var string
		 */
		public $version = LP_ADDON_CFMC_VER;

		/**
		 * @var string
		 */
		public $require_version = LP_ADDON_CFMC_REQUIRE_VER;

		public function __construct() {
			parent::__construct();
		}

	}
	
}

add_action( 'plugins_loaded', array( 'LP_Addon_ContentForMultipleCourses', 'instance' ) );