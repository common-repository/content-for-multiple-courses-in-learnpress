<?php
/**
 * Plugin Name: Content for multiple Courses in LearnPress
 * Description: Include Lessons, Quizzes and Questions in multiple Courses.
 * Plugin URI:  https://wordpress.org/plugins/content-for-multiple-courses-in-learnpress
 * Tags:        learnpress
 * Author:      Völker Webdesign Studio
 * Author URI:  http://voelker.studio
 * Version:     0.2
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: content-for-multiple-courses-in-learnpress
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( is_admin() ) {

    define( 'LP_ADDON_CFMC_FILE', __FILE__ );
    define( 'LP_ADDON_CFMC_VER', '0.2' );
    define( 'LP_ADDON_CFMC_REQUIRE_VER', '3.0.0' );

    if( ! function_exists( 'get_plugin_data' ) ){
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    if ( !class_exists( 'LearnPressContentForMultipleCourses_Plugin' ) ) {

        class LearnPressContentForMultipleCourses_Plugin {
        
            private $plugin_data;

            public function __construct() {
                $this->plugin_data = get_plugin_data( __FILE__ );

                add_action( 'learn-press/ready', array( $this, 'load_addon' ) );
                add_action( 'admin_notices', array( $this, 'admin_notices' ) );
            }

            function admin_notices() {
                ?>
                <div class="error">
                    <p><?php echo wp_kses(
                            sprintf(
                                __( '<strong>%s</strong> addon version %s requires %s version %s or higher <strong>installed</strong> and <strong>activated</strong>.', 'content-for-multiple-courses-in-learnpress' ),
                                    __( $this->plugin_data['Name'], 'content-for-multiple-courses-in-learnpress' ),
                                    LP_ADDON_CFMC_VER,
                                    sprintf( '<a href="%s" target="_blank"><strong>%s</strong></a>', admin_url( 'plugin-install.php?tab=search&type=term&s=learnpress' ), 'LearnPress' ),
                                    LP_ADDON_CFMC_REQUIRE_VER
                            ),
                            array(
                                'a' => array(
                                    'href'  => array(),
                                    'blank' => array()
                                ),
                                'strong' => array()
                            )
                        ); ?>
                    </p>
                </div>
                <?php
            }

            function load_addon() {
                LP_Addon::load( 'LP_Addon_ContentForMultipleCourses', 'inc/load.php', __FILE__ );
                remove_action( 'admin_notices', array( $this, 'admin_notices' ) );

                // override LearnPress exclude filter to disable excluding items
                add_filter( 'learn-press/modal-search-items/exclude', array(
                    $this,
                    'exclude_items'
                ), 99, 4 );
            }

            function exclude_items( $exclude, $type, $context = '', $context_id = null ) {
                return array();
            }

        }
        new LearnPressContentForMultipleCourses_Plugin();

    }

}