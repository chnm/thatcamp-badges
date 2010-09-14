<?php

if ( !class_exists( 'Thatcamp_Badges_Admin_Main' ) ) :

class Thatcamp_Badges_Admin_Main {

    function thatcamp_badges_admin_main () {
        add_action( 'admin_init', array ( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
    
    function init() {
        do_action( 'thatcamp_badges_admin_init' );
    }
    
    function admin_menu() {
        if (function_exists('add_menu_page')) {
            add_menu_page(__('THATCamp Badges'), __('TC Badges'), 'manage-options', dirname(__FILE__) . '/class-admin-main.php', array( $this, 'display'));
        }
    }

    function display() {
        $users = get_users_of_blog();
    ?>
        <div class="wrap">
        <h2><?php echo _e('THATCamp Badges'); ?></h2>

            <form action="" method="post">
            
            <label for="options[template]"><?php echo _e('Template'); ?></label>
            <select name="options[template]">
                <option value="avery74549.php">Avery 74549</option>
                <option value="avery74541.php">Avery 74541</option>
            </select>
            
            <?php if ( $users ) : ?>

            <table class="widefat fixed" cellspacing="0">
            <thead>
            <tr class="thead">
            <?php print_column_headers('users') ?>
            </tr>
            </thead>

            <tfoot>
            <tr class="thead">
            <?php print_column_headers('users', false) ?>
            </tr>
            </tfoot>

            <tbody id="users" class="list:user user-list">
            <?php
            $style = '';
            foreach ( $users as $user ) {
                $userid = $user->ID;
                $user_object = new WP_User($userid);
                $roles = $user_object->roles;
                $role = array_shift($roles);

                if ( is_multisite() && empty( $role ) )
                    continue;

                $style = ( ' class="alternate"' == $style ) ? '' : ' class="alternate"';
                echo "\n\t", user_row( $user_object, $style, $role );
            }
            ?>
            </tbody>
            </table>

            <?php endif; ?>

            <p><input type="submit" name="create_badges_pdf" value="<?php echo _e('Create Badge PDF'); ?>"></p>
            
        
        </form>
    
        </div>
    <?php
    }
}

endif;

$thatcamp_badges_admin_main = new Thatcamp_Badges_Admin_Main();

?>