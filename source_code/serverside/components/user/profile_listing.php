<?php
if (defined("CLIENT") === FALSE) {
    /**
     * Ghetto way to prevent direct access to "include" files.
     */
    http_response_code(404);
    die();
}

if (!$session_is_authenticated === True) {
    header("Location: login.php");
    exit;
}

require_once("serverside/functions/database.php");

// DB Conn Part
$conn = get_conn();

if ($session_is_authenticated === TRUE) {
    $current_user_id = (int)($_SESSION["user_id"]);
}

$profiles_results = array();
$profiles_sql = "SELECT user.id, user.name, user.email, user.join_date, user.gender, user.bio, user.profile_pic FROM user WHERE user.id = ?";
if ($query = $conn->prepare($profiles_sql)) {
    $query->bind_param("i", $current_user_id);
    $query->execute();
    $query->bind_result($id, $name, $email, $join_date, $gender, $bio, $profile_pic);

    while ($query->fetch()) {
        $data = array(
            "id" => (int)$id,
            "name" => $name,
            "email" => $email,
            "join_date" => $gender,
            "bio" => $bio,
            "profile_pic" => $profile_pic
        );
        array_push($profiles_results, $data);
    }
    $query->close();
}
?>