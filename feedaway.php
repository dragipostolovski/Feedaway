<?php
/*
 * Plugin Name: Feedaway
 * Description: Disables RSS feeds on the website.
 * Version: 1.0.1
 * Author: Projects Engine
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /languages/
 * Author:      Projects Engine
 * Author URI:  https://www.projectsengine.com/user/dragipostolovski
 * Text Domain: feedaway
*/

namespace projectsengine;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Feedaway' ) ) {
    class Feedaway {

        public function __construct() {
            define('DISABLE_FEED_VERSION', '1.0.1');

            register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );
            register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivate' ) );
            
            add_filter('plugins_loaded', array( __CLASS__, 'feedaway_plugins_loaded' ) );

                        
            add_action('do_feed', array( __CLASS__, 'feedaway_disable_feed'), 1);
            add_action('do_feed_rdf', array( __CLASS__, 'feedaway_disable_feed'), 1);
            add_action('do_feed_rss', array( __CLASS__, 'feedaway_disable_feed'), 1);
            add_action('do_feed_rss2', array( __CLASS__, 'feedaway_disable_feed'), 1);
            add_action('do_feed_atom', array( __CLASS__, 'feedaway_disable_feed'), 1);
            add_action('do_feed_rss2_comments', array( __CLASS__, 'feedaway_disable_feed'), 1);
            add_action('do_feed_atom_comments', array( __CLASS__, 'feedaway_disable_feed'), 1);

            remove_action( 'wp_head', 'feed_links_extra', 3 );
            remove_action( 'wp_head', 'feed_links', 2 );    
        }
        
        public static function activate() {
            update_option( 'disable_feed_version', DISABLE_FEED_VERSION );
        }
        
        public static function deactivate() {
            delete_option( 'disable_feed_version' );
        }

        public static function feedaway_plugins_loaded() {
            load_plugin_textdomain( 'feedaway-disable-feed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
        }

        public static function feedaway_disable_feed() {
            wp_die( __( 'No feed available', 'feedaway' ), 200 );
        }    
    }
    
    new Feedaway;
}
