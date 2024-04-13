<?php
include "./src/config/config.php";

session_start();

// Mendapatkan nilai dari form
$email = $_POST['email'];
$name = $_POST['name'];
$random_number = rand(1000, 9999);
$username = 'user' . $random_number;
$password = $_POST['password'];

//default profile picture
$profile_picture = 'uploads/profile_picture/profile_default.jpg';

$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];

// Format tanggal sesuai dengan yang diinginkan untuk disimpan di database
$birthday = "$year-$day-$month";

// Periksa apakah email sudah ada
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['email_exists'] = "Email sudah digunakan!";
    header("Location: index.php");
    exit; // Hentikan eksekusi skrip karena email sudah ada
}

// Siapkan dan jalankan query SQL untuk menyimpan data
$sql = "INSERT INTO users (email, name, username, profile_picture, password, birthday) VALUES ('$email', '$name', '$username', '$profile_picture' ,'$password', '$birthday')";

if ($conn->query($sql) === TRUE) {
    $new_user_id = $conn->insert_id;
    $_SESSION['id'] = $new_user_id;
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
