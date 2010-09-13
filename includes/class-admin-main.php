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
    		add_menu_page('Badges', 'Badges', 8, basename(__FILE__), array( $this, 'display'));
    	}
    }

    function display() {
        $blogUsers = get_users_of_blog(); //gets registered users
    
        // // print_r($users);
        //     
        // if(isset($_POST['create'])) {  
        // 
        //     $options = array(
        //             'background_image' => '/websites/thatcamp.org/wp-content/plugins/thatcamp-badges/images/thatcamp-badge-bg.jpg'
        //         );
        // 
        //     $users = array();
        //     if ($blogUsers) {
        //         foreach ($blogUsers as $blogUser) {
        //             $user = get_userdata($blogUser->ID);
        //             $users[] = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->user_email, 'user_url' => $user->user_url, 'twitter_username' => $user->twitter_username);
        //         }
        //     }
        //     
        //     // print_r($users);       
        //     $badges = new Thatcamp_Badges_Renderer($users, $options);
        //     $badges->render();
    ?>
        <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Conference Badges</h2>
    
        <p><a href="/wp-content/plugins/thatcamp-badges/badges.pdf">Download PDF</a></p>
    
        <form action="" method="post">

            <p><input type="submit" name="create" value="Create"></p>
            
        
        </form>
    
        <?php 
    
        // $blogUsers = get_users_of_blog();
        // 
        // foreach ($blogUsers as $blogUser) {
        //     $user = get_userdata($blogUser->ID);
        //     
        //     $gravatar = 'http://www.gravatar.com/avatar/'. md5($user->user_email).'?d=404';
        //             
        //     if (validate_gravatar($user->user_email)) {
        //         echo 'has a gravatar at <img src="'.$gravatar.'" />';
        //         
        //     } else {
        //         echo ' does not have a gravatar';
        //         
        //     }
        //     echo '<br />';
        // }
        ?>
        </div>
    <?php
    }
}

endif;

$thatcamp_badges_admin_main = new Thatcamp_Badges_Admin_Main();

?>