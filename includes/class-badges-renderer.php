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
            $options['template'] = 'avery74541.php';
        }

        $template = dirname( __FILE__ ) . '/badge-templates/'.$options['template'];

        // Set up the new PDF object
        $pdf = new FPDF('P', 'in', 'Letter');

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
        		
        		require($template);
                
                // // Add the background image for the badge to the page
                if ( isset($options['background_image']) ) { 
                    $pdf->Image($options['background_image'], $background_x, $background_y, 4, 3);
                }
                        
                // Set the co-ordinates, font, and text for the first name
                $pdf->SetXY($text_x, $text_y);
                $pdf->SetFont('helvetica', 'b', 22);
                $pdf->MultiCell(2.5, 0.5,ucwords(stripslashes($users[$i]['first_name'])),0,'L');
                
                // Set the co-ordinates, font, and text for the last name
                $pdf->SetXY($text_x, $text_y + 0.25);
                $pdf->SetFont('helvetica','',12);
                $pdf->MultiCell(2.5, 0.25,stripslashes(ucwords($users[$i]['last_name'])),0,'L');
                
                if ( $user_url = $users[$i]['user_url'] ) {
                
                    // Remove http:// from blog URL's and also remove ending slashes
                    $user_url = str_replace('http://', '', $user_url);
                
                    // Set the co-ordinates, font, and text for the blog url
                    $pdf->SetXY($text_x, $text_y + 0.5);
                    $pdf->SetFont('helvetica','',10);
                    $pdf->MultiCell(2.5,0.25,$users[$i]['user_url'],0,'L');
                }
                
        		$counter++;
        } 
        
        $file = 'badges.pdf';
        $pdf->Output($file, 'D');
    }
}
?>