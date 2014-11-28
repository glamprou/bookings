<?php
function smart_resize_image($file,$width=0, $height=0,$proportional=false,$output='file',$delete_original=true,$use_linux_commands=false ) {
      
	if ( $height <= 0 && $width <= 0 ) return false;
	
	# Setting defaults and meta
	$info                         = getimagesize($file);
	$image                        = '';
	$final_width                  = 0;
	$final_height                 = 0;
	list($width_old, $height_old) = $info;
	
	if($width_old>$width || $height_old>$height){
	
		# Calculating proportionality
		if ($proportional) {
		  if      ($width  == 0)  $factor = $height/$height_old;
		  elseif  ($height == 0)  $factor = $width/$width_old;
		  else                    $factor = min( $width / $width_old, $height / $height_old );
		
		  $final_width  = round( $width_old * $factor );
		  $final_height = round( $height_old * $factor );
		}
		else {
		  $final_width = ( $width <= 0 ) ? $width_old : $width;
		  $final_height = ( $height <= 0 ) ? $height_old : $height;
		}
		
		# Loading image to memory according to type
		switch ( $info[2] ) {
		  case IMAGETYPE_GIF:   $image = imagecreatefromgif($file);   break;
		  case IMAGETYPE_JPEG:  $image = imagecreatefromjpeg($file);  break;
		  case IMAGETYPE_PNG:   $image = imagecreatefrompng($file);   break;
		  default: return false;
		}
		
		
		# This is the resizing/resampling/transparency-preserving magic
		$image_resized = imagecreatetruecolor( $final_width, $final_height );
		if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
		  $transparency = imagecolortransparent($image);
		
		  if ($transparency >= 0) {
			$transparent_color  = imagecolorsforindex($image, $trnprt_indx);
			$transparency       = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			imagefill($image_resized, 0, 0, $transparency);
			imagecolortransparent($image_resized, $transparency);
		  }
		  elseif ($info[2] == IMAGETYPE_PNG) {
			imagealphablending($image_resized, false);
			$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
			imagefill($image_resized, 0, 0, $color);
			imagesavealpha($image_resized, true);
		  }
		}
		imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
		
		# Taking care of original, if needed
		if ( $delete_original ) {
		  if ( $use_linux_commands ) exec('rm '.$file);
		  else @unlink($file);
		}
		
		# Preparing a method of providing result
		switch ( strtolower($output) ) {
		  case 'browser':
			$mime = image_type_to_mime_type($info[2]);
			header("Content-type: $mime");
			$output = NULL;
		  break;
		  case 'file':
			$output = $file;
		  break;
		  case 'return':
			return $image_resized;
		  break;
		  default:
		  break;
		}
		# Writing image according to type to the output destination
		switch ( $info[2] ) {
		  case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
		  case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output);   break;
		  case IMAGETYPE_PNG:   imagepng($image_resized, $output);    break;
		  default: return false;
		}
	}
	/*$canvas = imagecreatetruecolor(300, 400);
	imagefilledrectangle($canvas,0,0,300, 400,imagecolorallocate($canvas, 255, 255, 255));
	if($width_old<$width && $height_old<$height){
		$output=$file;
	}
	// get the image from file...
	list($width, $height) = getimagesize($output);
	//echo $width."-".$height." ";
	$img = imagecreatefromjpeg($output);
	
	// resample image and place it in center of canvas
	$x = intval((300-$width) / 2);
	$y = intval((400-$height) / 2); 
	imagecopyresampled($canvas, $img, $x, $y, 0, 0, $width, $height, $width, $height);
	imagejpeg($canvas, $output);
	return true;*/
}
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

$db=ServiceLocator::GetDatabase();
$db->Connection->Connect(); 

$userSession = ServiceLocator::GetServer()->GetUserSession();
$userid=(int)mysql_real_escape_string($_POST['userid']);
if(!$userid){
	echo "";
	exit;
}
if(isset($_FILES['profileImage'])){
	$allowedExts = array("jpeg", "jpg", "png", "gif");
	$temp = explode(".", $_FILES["profileImage"]["name"]);
	$extension = end($temp);
	if ((($_FILES["profileImage"]["type"] == "image/jpeg")
	|| ($_FILES["profileImage"]["type"] == "image/jpg")
	|| ($_FILES["profileImage"]["type"] == "image/gif")
	|| ($_FILES["profileImage"]["type"] == "image/png"))
	&& in_array($extension, $allowedExts))
		{
		$new_image_name="profile_image_$userid.".$extension;
		if ($_FILES["file"]["error"] > 0)
			{
			echo "Return Code: " . $_FILES["profileImage"]["error"] . "<br>";
			}
		else
			{
				$_FILES["profileImage"]["name"]=$new_image_name;
				move_uploaded_file($_FILES["profileImage"]["tmp_name"],
					ROOT_DIR."Web/uploads/profile_images/" . $_FILES["profileImage"]["name"]);
				$res=mysql_query("select * from user_profile_info where user_id=$userid");
				if(mysql_num_rows($res)==0){
					mysql_query("insert into user_profile_info (user_id,user_profile_img) values ($userid,'uploads/profile_images/".$new_image_name."')");
				}		
				else{
					mysql_query("update user_profile_info set user_profile_img='".'uploads/profile_images/'.$new_image_name."' where user_id=$userid");
				}
				smart_resize_image('uploads/profile_images/'.$new_image_name,100,0,true,'uploads/profile_images/'.$new_image_name);
			}
		}
	header('Location: admin/manage_users.php');
}
if(isset($_POST['delete_profile_image'])){
	mysql_query("delete from user_profile_info where user_id=$userid");
}
?>