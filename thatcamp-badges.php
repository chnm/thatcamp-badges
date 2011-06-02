<?php
/*
Plugin Name: THATCamp Badges
Plugin URI: http://www.thatcamp.org
Description: Creates a formatted PDF for printing conferences badges based on selected users in your WordPress site.
Author: Center for History and New Media
Author URI: http://chnm.gmu.edu
Version: 1.0-alpha
*/

/*
Copyright (C) 2010-2011 Center for History and New Media, George Mason University

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

class Thatcamp_Badges {
    
    function thatcamp_badges() {

        add_action( 'plugins_loaded', array ( $this, 'loaded' ) );

        add_action( 'init', array ( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        // Include the necessary files
        add_action( 'thatcamp_badges_loaded', array ( $this, 'includes' ) );

        // Attach textdomain for localization
        add_action( 'thatcamp_badges_init', array ( $this, 'textdomain' ) );

    }

    // Let plugins know that we're initializing
    function init() {
        do_action( 'thatcamp_badges_init' );
    }

    // Allow this plugin to be translated by specifying text domain
    // Todo: Make the logic a bit more complex to allow for custom text within a given language
    function textdomain() {
        $locale = get_locale();

        // First look in wp-content/thatcamp-badges-files/languages, where custom language files will not be overwritten by Anthologize upgrades. Then check the packaged language file directory.
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
            require_once( dirname( __FILE__ ) . '/includes/functions.php' );
            require_once( dirname( __FILE__ ) . '/includes/class-badges-renderer.php' );
        }
    }

    // Let plugins know that we're done loading
    function loaded() {
        do_action( 'thatcamp_badges_loaded' );
    }
    
    function admin_menu() {
        if (function_exists('add_users_page')) {
            add_users_page(__('Create User Badges'), __('Create Badges'), 'manage-options', 'thatcamp-badges', array( $this, 'display'));
        }
    }

    function display() {
        if ($_POST) {
            $this->create_badges_pdf($_POST);
        }
    ?>
        <div class="wrap">
            <h2><?php echo _e('Create User Badges'); ?></h2>
            <form action="<?php get_admin_url(); ?>users.php?page=thatcamp-badges&amp;noheader=true" method="post">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="options[template]"><?php _e('Template'); ?></label></th>
                        <td>
                            <select name="options[template]">
                                <option value="avery74541.php">Avery 74541</option>
                                <option value="avery74549.php">Avery 74549</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="options[background_image]"><?php _e('Background Image'); ?></label></th>
                        <td>
                            <select name="options[background_image]">
                            <?php
                            $images = get_posts('post_type=attachment&post_status=any&post_mime_type=image/jpeg,image/png' );
                            foreach ($images as $image ) { ?>
                            <option value="<?php echo wp_get_attachment_url( $image->ID ); ?>"><?php echo $image->post_title; ?></option>
                            <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="include_users"><?php _e('Include Users'); ?></label></th>
                        <td>
                            <input type="text" name="include_users">
                            <p><small>A comma-separated list of user IDs.</small></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th></th>
                        <td><input type="submit" name="create_badges_pdf" class="button-primary" value="<?php echo _e('Create Badge PDF'); ?>"></td>
                    </tr>
                </table>
            </form>
        </div>
    <?php
    }
    
    function create_badges_pdf($post = array()) {
        if ($post && array_key_exists('create_badges_pdf', $post) ) {
            $args = array();
            if ($includeUsers = explode(',', $post['include_users'])) {
                $args['include'] = $includeUsers;
            }
            $users = get_users($args);
            $options = isset($post['options']) ? $post['options'] : array();
                    
            if ($users) {
                foreach ($users as $user) {
                    $userData = get_userdata($user->ID);
                    $userDataArray = array('first_name' => $userData->first_name, 'last_name' => $userData->last_name, 'email' => $userData->user_email, 'user_url' => $userData->user_url);
                    if ($userTwitter = $userData->user_twitter) {
                        $userDataArray['user_twitter'] = $userTwitter;
                    }
                    $userArray[] = $userDataArray;
                    
                }
                $badges = new Thatcamp_Badges_Renderer($userArray, $options);
                $badges->render();
            }            
        }
        return false;
    }
}

$thatcamp_badges = new Thatcamp_Badges();