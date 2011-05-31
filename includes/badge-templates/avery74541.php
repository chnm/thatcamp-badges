<?php
// Add a page, but only on a multiple of 6
if ( $counter == 1 || ( $counter % 6 == 1 ) ) {
    $pdf->AddPage('P', 'Letter');
    $counter = 1;
}

$badgeHeight = 3;
$badgeWidth = 4;

$topX = 0.25;
$topY = 1;

// Set the co-ordinates for all items in each of the badges
switch ( $counter ) {
    case 1:
        $background_x = $topX;
        $background_y = $topY;
    break;
    case 2:
        $background_x = $topX + $badgeWidth;
        $background_y = $topY;
    break;
    case 3:
        $background_x = $topX; // mm from left
        $background_y = $topY + $badgeHeight;
    break;
    case 4:
        $background_x = $topX + $badgeWidth;
        $background_y = $topY + $badgeHeight;
    break;
    case 5:
        $background_x = $topX;
        $background_y = $topY + ($badgeHeight * 2);
    break;
    case 6:
        $background_x = $topX + $badgeWidth;
        $background_y = $topY + ($badgeHeight * 2);
    break;
}

$text_x = $background_x + 0.25;
$text_y = $background_y + 0.25;
?>