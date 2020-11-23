<?

$mainWidth="300";
$thumbWidth="150";

if($ImageFile_type=="image/pjpeg" or $ImageFile_type=="image/jpeg"):
	$ImageFileLink=imagecreatefromjpeg($_FILES["ImageFile"]["tmp_name"]);
elseif($ImageFile_type=="image/gif"):
	$ImageFileLink=imagecreatefromgif($_FILES["ImageFile"]["tmp_name"] );
endif;
	
$width = imagesx($ImageFileLink); // get original source image width
$height = imagesy($ImageFileLink); // and height

if($width>$height):
	$Ratio=$width/$height;
	$mainHeight=$mainWidth/$Ratio;
	$thumbHeight=$thumbWidth/$Ratio;
else:
	$Ratio=$height/$width;
	$mainHeight=$mainWidth;
	$thumbHeight=$thumbWidth;
	$mainWidth=$mainHeight/$Ratio;
	$thumbWidth=$thumbHeight/$Ratio;
endif;


$NewImageName=ereg_replace(" ","_",$ImageFile_name);

$main_img = @imagecreatetruecolor($mainWidth, $mainHeight);
$thumb_img = @imagecreatetruecolor($thumbWidth, $thumbHeight);

$main_result = imagecopyresampled($main_img, $ImageFileLink,0, 0, 0, 0,$mainWidth, $mainHeight,$width, $height); // resize the image
$thumb_result = imagecopyresampled($thumb_img, $ImageFileLink,0, 0, 0, 0,$thumbWidth, $thumbHeight,$width, $height); // resize the image

if($ImageFile_type=="image/pjpeg" or $ImageFile_type=="image/jpeg"):
	imagejpeg($main_img,"$ImageDirectory"."$NewImageName",100);
	imagejpeg($thumb_img,"$ThumnailDirectory"."$NewImageName",100);
elseif($ImageFile_type=="image/gif"):
	imagegif($main_img,"$ImageDirectory"."$NewImageName",100);
	imagegif($thumb_img,"$ThumnailDirectory"."$NewImageName",100);
endif;
imagedestroy($ImageFileLink);
?>