<?php
/*
Plugin Name: THATCamp Badges
Plugin URI: http://www.thatcamp.org
Description: Creates a formatted PDF for printing conferences badges based on selected users in your WordPress site.
Author: Center for History and New Media
Author URI: http://chnm.gmu.edu
Version: 1.0
*/

/*
Copyright (C) 2010 Center for History and New Media, George Mason University

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.

Based on badge-gen code released by Andy Peatling at http://apeatling.wordpress.com/2008/08/08/creating-gravatar-enabled-conference-badges-a-how-to/ 

THATCamp Badges uses the FPDF library by Olivier Plathey, available at http://www.fpdf.org/.
*/

if ( !class_exists('Thatcamp_Badges_Loader') ):

class Thatcamp_Badges_Loader {
    
	function thatcamp_badges_loader () {

		add_action( 'plugins_loaded', array ( $this, 'loaded' ) );

		add_action( 'init', array ( $this, 'init' ) );

		// Include the necessary files
		add_action( 'thatcamp_badges_loaded', array ( $this, 'includes' ) );

		// Attach textdomain for localization
		add_action( 'thatcamp_badges_init', array ( $this, 'textdomain' ) );
		
		add_action( 'thatcamp_badges_init', array ( $this, 'create_badges_pdf' ) );
		
	}

	// Let plugins know that we're initializing
	function init() {
		do_action( 'thatcamp_badges_init' );
	}

	// Allow this plugin to be translated by specifying text domain
	// Todo: Make the logic a bit more complex to allow for custom text within a given language
	function textdomain() {
		$locale = get_locale();

		// First look in wp-content/anthologize-files/languages, where custom language files will not be overwritten by Anthologize upgrades. Then check the packaged language file directory.
		$mofile_custom = WP_CONTENT_DIR . "/thatcamp-badges-files/languages/thatcamp-badges-$locale.mo";
		$mofile_packaged = WP_PLUGIN_DIR . "/thatcamp-badges/languages/thatcamp-badges-$locale.mo";

    	if ( file_exists( $mofile_custom ) ) {
      		load_textdomain( 'thatcamp-badges', $mofile_custom );
      		return;
      	} else if ( file_exists( $mofile_packaged ) ) {
      		load_textdomain( 'thatcamp-badges', $mofile_packaged );
      		return;
      	}
	}

	function includes() {
		if ( is_admin() ) {
			require( dirname( __FILE__ ) . '/includes/class-admin-main.php' );			
        }
		require_once( dirname( __FILE__ ) . '/includes/functions.php' );
	}

	// Let plugins know that we're done loading
	function loaded() {
		do_action( 'thatcamp_badges_loaded' );
	}
	
	function create_badges_pdf() {
		if ( array_key_exists('create_badges_pdf', $_POST) ) {
		    
		    require( WP_PLUGIN_DIR . '/thatcamp-badges/includes/class-badges-renderer.php' );
		    
		    $userIds = isset($_POST['users']) ? $_POST['users'] : array();
            $options = isset($_POST['options']) ? $_POST['options'] : array();
            	    
            if ($userIds) {
                foreach ($userIds as $userId) {
                    $user = get_userdata($userId);
                    $users[] = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->user_email, 'user_url' => $user->user_url);
                }
                
                $badges = new Thatcamp_Badges_Renderer($users, $options);
                $badges->render();
            }
            
		    load_template( WP_PLUGIN_DIR . '/thatcamp-badges/includes/class-admin-main.php?' );
            

		}
		return false;
	}
}

endif;

$thatcamp_badges_loader = new Thatcamp_Badges_Loader();
