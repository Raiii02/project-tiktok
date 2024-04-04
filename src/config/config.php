<?php

$conn = new mysqli("localhost", "root", "", "clone-tiktok");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
