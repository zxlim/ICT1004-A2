<?php

//upload.php
$user_id = 1;
$folder_name = 'serverside/components/uploads/' . $user_id . '/';

if (!file_exists($folder_name)) {
    mkdir($folder_name, 0777,true);
}

if (!empty($_FILES)) {
    $temp_file = $_FILES['file']['tmp_name'];
    $location = $folder_name . $_FILES['file']['name'];
    move_uploaded_file($temp_file, $location);
}

if (isset($_POST["name"])) {
    $filename = $folder_name . $_POST["name"];
    unlink($filename);
}

$result = array();

$files = scandir($folder_name);

$output = '<div class="row">';

if (false !== $files) {
    foreach ($files as $file) {
        if ('.' != $file && '..' != $file) {
            $output .= '
   <div class="col-lg-4">
    <img src="' . $folder_name . $file . '" class="img-thumbnail" width="175" height="175" style="height:175px;" />
    <hr>
    <button type="button" class="genric-btn danger-border small remove_image" id="' . $file . '">Remove</button>
   </div>
   ';
        }
    }
}
$output .= '</div>';
echo $output;

?>