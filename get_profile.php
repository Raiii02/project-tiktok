<?php
include './src/config/config.php';
session_start();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $userQuery = "SELECT * FROM users WHERE id = $user_id";
    $userResult = mysqli_query($conn, $userQuery);

    if ($userResult && $userResult->num_rows > 0) {
        $userData = mysqli_fetch_assoc($userResult);
        echo json_encode($userData);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
