<?php
if (defined("CLIENT") === FALSE) {
    /**
     * Ghetto way to prevent direct access to "include" files.
     */
    http_response_code(404);
    die();
}
$user_id = $_GET['id'];

if (!$session_is_authenticated === True) {
    header("Location: login.php");
    exit;
}

if ($session_is_authenticated === TRUE) {
    $current_user_id = (int)($_SESSION["user_id"]);
}

require_once("serverside/functions/database.php");

// DB Conn Part
$conn = get_conn();

// This part is when the user click his own profile
$own_profile_results = array();
$own_profiles_sql = "SELECT user.id, user.name, user.email, user.join_date, user.gender, user.bio, user.profile_pic FROM user WHERE id = ?";
#$sql = "SELECT admin from user WHERE loginid = '".$loginid."'";
if ($query = $conn->prepare($own_profiles_sql)) {
    $query->bind_param("i", $user_id);
    $query->execute();
    $query->bind_result($id, $name, $email, $join_date, $gender, $bio, $profile_pic);

    while ($query->fetch()) {
        $data = array(
            "id" => (int)$id,
            "name" => $name,
            "email" => $email,
            "join_date" => $join_date,
            "gender" => $gender,
            "bio" => $bio,
            "profile_pic" => $profile_pic
        );
        array_push($own_profile_results, $data);
    }
    $query->close();
}
?>