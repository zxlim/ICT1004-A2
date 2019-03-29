<?php
if (!empty($_FILES)) {
    $fileName = $_FILES['file']['name'];
    echo $fileName;
}
?>


