<?php
require_once('fpdf/fpdf.php');

class Thatcamp_Badges_Renderer {
    
    function thatcamp_badges_renderer($users = array(), $options = array()) {
        $this->users = $users;
        $this->options = $options;
    }
    
    function render() {
        
        $users = $this->users;     
        $options = $this->options;
        
        if (!array_key_exists('template', $options)) {
            $options['template'] = 'avery74549.php';
        }
        
        // Set up the new PDF object
        $pdf = new FPDF();

        // Set the text color to white.
        $pdf->SetTextColor(0,0,0);

        // Remove page margins.
        $pdf->SetMargins(0, 0);

        // Disable auto page breaks.
        $pdf->SetAutoPageBreak(0);

        // Set up badge counter
        $counter = 1;

        // Loop through each attendee and create a badge for them
        for ( $i = 0; $i < count($users); $i++ ) {
        		// Grab the template file that will be used for the badge page layout
        		
        		$template = 'badge-templates/'.$options['template'];
        		require($template);
                
                // // Add the background image for the badge to the page
                if ( isset($options['background_image']) ) { 
                    $pdf->Image($options['background_image'], $background_x, $background_y, 88, 57);
                }
                
                // if (validate_gravatar($users[$i]['email'])) {
                //  // Download and store the gravatar for use, FPDF does not support gravatar formatted image links
                //     $grav_file_raw = '/websites/thatcamp.org/wp-content/plugins/thatcamp-badges/images/temp/' . $users[$i]['first_name'] . '-' . rand();
                // 
                //     $grav_data = get_file_by_curl( 'http://www.gravatar.com/avatar/' . md5($users[$i]['email']) . '.jpg', $grav_file_raw );
                // 
                //     // Check if the image is a png, if it is, convert it, otherwise add a JPG extension to the raw filename
                //     if ( !$grav_file = pngtojpg($grav_file_raw) ) {
                //      $grav_file_extension = get_image_extension($grav_file_raw);
                //      $grav_file = $grav_file_raw . $grav_file_extension;
                //      rename( $grav_file_raw, $grav_file );
                //     }
                // } else {
                //     $grav_file = 'http://thatcamp.org/wp-content/plugins/thatcamp-badges/images/thatcamp-gravatar-default.jpg';
                // }
                // 
                // $pdf->Image($grav_file, $avatar_x, $avatar_y + 5, 21, 21);
                        
                // Set the co-ordinates, font, and text for the first name
                $pdf->SetXY($text_x, $text_y);
                $pdf->SetFont('helvetica', 'b', 22);
                $pdf->MultiCell(86, 13,ucwords(stripslashes($users[$i]['first_name'])),0,'L');
                
                // Set the co-ordinates, font, and text for the last name
                $pdf->SetXY($text_x, $text_y + 6);
                $pdf->SetFont('helvetica','',12);
                $pdf->MultiCell(86, 13,stripslashes(ucwords($users[$i]['last_name'])),0,'L');
                
                if ( $user_url = $users[$i]['user_url'] ) {
                
                    // Remove http:// from blog URL's and also remove ending slashes
                    $user_url = str_replace('http://', '', $user_url);
                
                    // Set the co-ordinates, font, and text for the blog url
                    $pdf->SetXY($text_x, $text_y + 18);
                    $pdf->SetFont('helvetica','',10);
                    $pdf->MultiCell(86, 13,$users[$i]['user_url'],0,'L');
                }
                
        		$counter++;
        } 
        
        $file = 'badges.pdf';
        $pdf->Output($file, 'I');
    }
}
?>