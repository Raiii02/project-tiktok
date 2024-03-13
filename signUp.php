<?php
include "./src/config/config.php";

session_start();

// Mendapatkan nilai dari form
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$day = $_POST['day'];
$month = $_POST['month'];
$year = $_POST['year'];

// Format tanggal sesuai dengan yang diinginkan untuk disimpan di database
$birthday = "$year-$month-$day";

// Periksa apakah username sudah ada
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Username sudah digunakan.";
    exit; // Hentikan eksekusi skrip karena username sudah ada
}

// Periksa apakah email sudah ada
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Email sudah terdaftar.";
    exit; // Hentikan eksekusi skrip karena email sudah ada
}

// Siapkan dan jalankan query SQL untuk menyimpan data
$sql = "INSERT INTO users (email, username, password, birthday) VALUES ('$email', '$username', '$password', '$birthday')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
