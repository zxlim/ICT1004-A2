<?php
if (defined("CLIENT") === FALSE) {
    /**
     * Ghetto way to prevent direct access to "include" files.
     */
    http_response_code(404);
    die();
}

require_once("serverside/functions/validation.php");

if ($session_is_admin === TRUE) {
    // No admins allowed here.
    header("Location: index.php");
    die(); // Prevent further execution of PHP code.
}

if (isset($_GET['id']) === TRUE && validate_int($_GET['id']) === TRUE) {
    $user_id = (int)($_GET['id']);
} else if (session_isauth() === TRUE) {
    $user_id = $_SESSION["user_id"];
} else {
    // Default profile.
    $user_id = 1;
}

require_once("serverside/functions/database.php");

// DB Conn Part
$conn = get_conn();

// This part is when the user click his own profile
$profile = NULL;

$sql = "SELECT id, name, email, join_date, gender, bio, profile_pic, admin FROM user WHERE id = ?";

if ($query = $conn->prepare($sql)) {
    $query->bind_param("i", $user_id);
    $query->execute();
    $query->bind_result($id, $name, $email, $join_date, $gender, $bio, $profile_pic, $admin);

    if ($query->fetch()) {
        if ((bool)($admin) === FALSE) {
            $profile = array(
                "id" => (int)$id,
                "name" => $name,
                "email" => $email,
                "join_date" => $join_date,
                "gender" => $gender,
                "bio" => $bio,
                "profile_pic" => $profile_pic
            );
        }
    }

    $query->close();
}

$conn->close();
