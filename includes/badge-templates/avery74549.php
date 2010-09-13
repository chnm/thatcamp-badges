<?php
// Add a page, but only on a multiple of 8
if ( $counter == 1 || ( $counter % 8 == 1 ) ) {
	$pdf->AddPage('P', 'Letter');
	$counter = 1;
}

$badgeWidth = 88;
$badgeHeight = 57;

$topX = 19;
$topY = 25;

// Set the co-ordinates for all items in each of the badges
switch ( $counter ) {
	case 1:
		$background_x = $topX; // mm from left
		$background_y = $topY; // mm from top
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX; // mm from left
		$avatar_y = $avatarOffsetY; // mm from top
		$text_x = $textOffsetX; // mm from left
		$text_y = $textOffsetY; // mm from top
	break;
	case 2:
		$background_x = $topX + $badgeWidth;
		$background_y = $topY;
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX; //mm from left
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;
	break;
	case 3:
		$background_x = $topX; // mm from left
		$background_y = $topY + $badgeHeight;
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX;
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;
	break;
	case 4:
		$background_x = $topX + $badgeWidth;
		$background_y = $topY + $badgeHeight;
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX;
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;
	break;
	case 5:
		$background_x = $topX;
		$background_y = $topY + ($badgeHeight * 2);
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX;
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;			
	break;
	case 6:
		$background_x = $topX + $badgeWidth;
		$background_y = $topY + ($badgeHeight * 2);
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX;
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;			
	break;
	case 7:
		$background_x = $topX;
		$background_y = $topY + ($badgeHeight * 3);
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX;
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;			
	break;
	case 8:
		$background_x = $topX + $badgeWidth;
		$background_y = $topY + ($badgeHeight * 3);
		
		$avatarOffsetX = $background_x + 63;
        $avatarOffsetY = $background_y + 6;
        $textOffsetX = $background_x + 6;
        $textOffsetY = $background_y + 6;
        
		$avatar_x = $avatarOffsetX;
		$avatar_y = $avatarOffsetY;
		$text_x = $textOffsetX;
		$text_y = $textOffsetY;			
	break;
}
?>