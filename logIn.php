<?php
// Sertakan file config.php untuk koneksi ke database
include "./src/config/config.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari form
    $username_email = $_POST["username_email"];
    $password = $_POST["password"];

    // Lakukan proses autentikasi dengan database
    $sql = "SELECT * FROM users WHERE (username = '$username_email' OR email = '$username_email')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username/Email ditemukan, periksa password
        $row = $result->fetch_assoc(); 
        $stored_password = $row["password"];
        if ($stored_password === $_POST["password"]) {
            $_SESSION['id'] = $row['id'];
            if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                header("Location: index.php"); // Redirect ke halaman index.php setelah login berhasil
                exit; // Pastikan tidak ada output lain sebelum header
            }
        } else {
            $_SESSION['password_incorrect'] = " Password yang Anda masukkan tidak benar. Mohon periksa kembali";
            header("Location: index.php");
            exit; // Hentikan eksekusi skrip karena email sudah ada
        }
    } else {
        $_SESSION['username_email_dne'] = "Username/Email tidak ditemukan";
        header("Location: index.php");
        exit; // Hentikan eksekusi skrip karena email sudah ada
    }
}
