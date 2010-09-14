<?php

function thatcamp_get_file_by_curl( $file, $newfilename ) {
    $out = fopen( $newfilename, 'wb' );
    $ch = curl_init(); 

    curl_setopt( $ch, CURLOPT_FILE, $out );
    curl_setopt( $ch, CURLOPT_HEADER, 0 );
    curl_setopt( $ch, CURLOPT_URL, $file ); 

    curl_exec( $ch );
    curl_close( $ch );
}

function thatcamp_get_image_extension($filename) {
    $type_mapping =  array( '1' => 'image/gif', '2' => 'image/jpeg', '3' => 'image/png' );
    @$size = GetImageSize( $filename );

    if ( $size[2] && $type_mapping[$size[2]] ) {
        if ( $type_mapping[$size[2]] == 'image/gif' )
                return '.gif';

        if ( $type_mapping[$size[2]] == 'image/jpeg' )
            return '.jpg';

        if ( $type_mapping[$size[2]] == 'image/png' )
            return '.png';
    }
    return '.jpg';
}

function thatcamp_png_to_jpg( $file ) {
    if ( get_image_extension( $file ) == '.png' ) {
        $image = imagecreatefrompng( $file );
        imagejpeg( $image, $file . '.jpg', 80 );
        return $file . '.jpg';
    } else {
        return false;
    }
}

function thatcamp_validate_gravatar($email) {
    // Craft a potential url and test its headers
    $hash = md5($email);
    $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
    $headers = @get_headers($uri);
    if (!preg_match("|200|", $headers[0])) {
        $has_valid_avatar = FALSE;
    } else {
        $has_valid_avatar = TRUE;
    }
    return $has_valid_avatar;
}


function thatcamp_file_is_404($file) {

    $is404 = false;
    
    // Create a curl handle
    $ch = curl_init($file);

    $output = curl_exec($ch);
    
    echo $output; exit;
    // Check if any error occured
    //if(!curl_errno($ch))
    //{
        $info = curl_getinfo($ch);
        var_dump($info);
        $is404 = ($info['http_code'] == '404'); // || $info['http_code'] == 0); 
    //} 

    // Close handle
    curl_close($ch);
    
    return $is404;
}

function thatcamp_get_user_avatar($user, $size = "", $placeholder = "", $border = "", $class = "", $usegravatar = 0, $rating = "") {
   
   // Will load the function that will mess with Twitter API (see bellow) It sends the comment author mail
   $result = get_user_twitter_info($user->twitter_username);  
      
   // After getting the responses from the function we will proceed

// In the case of we setup a border we will add a string with the border info   
if ($border != "") {
$stringadd = "border-width:2px; border-color:".$border."; border-style:solid;";
}     
 // lets handle the size. Like twitter has different default image sizes we will tell the plugin to get the one that 
 // can be better used with the set size
 if ($size == "") {
 $finalsize = "48px;";
 $suffix = "_normal";
 } else if ($size <= "60" && $size >= "34") {
 $finalsize = $size."px;";
 $suffix = "_normal";
 } else if ($size <= "35" && $size >= "0") {
 $finalsize = $size."px;";
 $suffix = "_mini";
 } else if ($size <= "90" && $size >= "61") {
 $finalsize = $size."px;";
 $suffix = "_bigger";
 } else if ($size >= "91") {
 $finalsize = $size."px;";
 $suffix = "";
 }
 
 // If User has no twitter    
if($result===false) {
    return 'false!!!';
    // In case we want our own image and not the default one lets tell it
    if ($placeholder != "") {
        $imagee = $placeholder;
    } else {
        // in the case we want the default image let's load it
        $imagee = get_option('siteurl')."/wp-content/plugins/twittar/default".$suffix.".png";
    }
    // If we want to use gravatar we will handle a couple of things
    if ($usegravatar == 1) {
             if ($size == "") {
                 // Size: Like gravatar default size is different from Twittar's one we will setup a new size when we 
                 // request the gravatar of the user
        $size = "48";
        }

   // Lets build the gravatar url :)
      $image = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($user->user_email);
    if($rating && $rating != '')  {
        $image .= "&amp;rating=".$rating;
    }
    if($size && $size != '')     {
        $image .="&amp;size=".$size;
    }
            if($border && $border != '')     {
        $image .= "&amp;border=".$border;
            }

        $image .= "&amp;default=".urlencode($imagee);  // Not here that this image will be the defautl one or the placeholder if user has no gravatar as well
 
    }   else {
        // If we do not want to use gravatar the image we will load will be either the default one or the placeholder.
        // Difference: we dont request the gravatar first!
$image = $imagee;
    }
} else {
 // If user has twitter :)

print_r($result);

$quaseimg = $result->profile_image_url;  // we get user image from array we built in the process function
// we need to make some calcs to get the image without _normal.png (we will add .png later and _normal deppending on the choosen size)

echo $quaseimg; exit;

$wherestop = strrpos($quaseimg, "_");  
$lenght = strlen( $quaseimg  );
$takeof = $lenght-$wherestop;
$keepit = $lenght-4;
$fileextension = substr($quaseimg, $keepit, 4);
// Here we have a complete image url:
$image = substr($quaseimg, 0, -$takeof).$suffix.$fileextension; 

// Let's pay attention: If in the url we find static.twitter.com it means is the default img so lets go to our gravatar/default process   
if (strpos($quaseimg, "static.twitter.com") !== false) {
  // Same thing as we did before let's load either the placeholder (if set) or the default img
    if ($placeholder != "") {
        $imagee = $placeholder;
    } else {
        $imagee = get_option('siteurl')."/wp-content/plugins/twittar/default".$suffix.".png";
    }
    // if we want to use gravatar...
    if ($usegravatar == 1) {
        if ($size == "") {
            // ... we adjust the image size
        $size = "48";
        }
        // We build the url
        $image = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($user->user_email);
    if($rating && $rating != '')
        $image .= "&amp;rating=".$rating;
    if($size && $size != '')
        $image .="&amp;size=".$size;

        $image .= "&amp;default=".urlencode($imagee);     // here we load the default/placeholder img if user has no gravatar
            if($border && $border != '')
        $image .= "&amp;border=".$border;

    }   else {
        // else we use the default img/placeholder
$image = $imagee;
    }          
 }   

} 
// Now let's build the img tag
 // echo '<img src="'.$image.'" alt="'.$result->name.'" class="'.$class.'" title="'.$result->name.'" style="width:'.$finalsize.' height:'.$finalsize.' '.$stringadd.'" />';
 
 return $image;     
 
}