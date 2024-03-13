<?php
include "./src/config/config.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $username_email = $_POST["username_email"];
    $password = $_POST["password"];

    // Validasi form (bisa ditambahkan validasi tambahan sesuai kebutuhan)
    if (empty($username_email) || empty($password)) {
        echo "Username/Email dan password harus diisi.";
    } else {
        // Lakukan proses autentikasi dengan database
        $sql = "SELECT * FROM users WHERE (username = '$username_email' OR email = '$username_email') AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Username/Email ditemukan, periksa password
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];
            if ($stored_password === $_POST["password"]) {
                header("Location: index.php");
            } else {
                echo "Password salah.";
            }
        } else {
            echo "Username/Email tidak ditemukan.";
        }
    }
}
