<?php
//uploader
if(isset($_FILES["file"]["name"]))
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = rand(100, 99999) . time() . '.' . $ext;
 $location = 'uploads/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 //echo json_encode(array("imageLocation"=>$location,"status"=>1));
 echo $location;
 //echo '<img src="'.$location.'" alt="Student Image" class="card-img-top" id="previewImg" " />';
}

?>