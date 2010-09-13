<?php
// Add a page, but only on a multiple of 6
if ( $counter == 1 || ( $counter % 9 == 1 ) ) {
	$pdf->AddPage('P', 'Letter');
	$counter = 1;
}

// Set the co-ordinates for all items in each of the badges
switch ( $counter ) {
	case 1:
		$background_x = 6.25;
		$background_y = 24;
		$avatar_x = 75;
		$avatar_y = 32;
		$text_x = 15;
		$text_y = 65;
	break;
	case 2:
		$background_x = 108.5;
		$background_y = 24;
		$avatar_x = 177.25;
		$avatar_y = 32;
		$text_x = 119;
		$text_y = 65;
	break;
	case 3:
		$background_x = 6.25;
		$background_y = 100;
		$avatar_x = 75;
		$avatar_y = 108;
		$text_x = 17.5;
		$text_y = 141;
	break;
	case 4:
		$background_x = 108.5;
		$background_y = 100;
		$avatar_x = 177.25;
		$avatar_y = 108;
		$text_x = 114;
		$text_y = 141;
	break;
	case 5:
		$background_x = 6.25;
		$background_y = 176;
		$avatar_x = 75;
		$avatar_y = 184;
		$text_x = 17.5;
		$text_y = 217;			
	break;
	case 6:
		$background_x = 108.5;
		$background_y = 176;
		$avatar_x = 177.25;
		$avatar_y = 184;
		$text_x = 114;
		$text_y = 217;			
	break;
}
?>