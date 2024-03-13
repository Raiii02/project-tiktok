<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "clone-tiktok";

$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
