<?php
include "./src/config/config.php";
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['cancel'])) {
            // Jika tombol "Batal" diklik, arahkan pengguna kembali ke halaman profil
            header("Location: profile.php");
            exit();
        }

        $username = $_POST['username'];
        $name = $_POST['name'];
        $bio = $_POST['bio'];
        $user_id = $_SESSION['id'];

        // Cek apakah ada file foto profil yang diunggah
        if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            // Direktori penyimpanan foto profil
            $upload_dir = 'uploads/profile_picture/';
            // Nama file
            $filename = basename($_FILES['profile_picture']['name']);
            // Path lengkap file
            $upload_file = $upload_dir . $filename;

            // Pindahkan file yang diunggah ke direktori penyimpanan
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
                // Persiapkan query untuk memperbarui profil termasuk foto profil
                $update_query = "UPDATE users SET name='$name', bio='$bio', username='$username', profile_picture='$upload_file' WHERE id='$user_id'";

                // Eksekusi query untuk memperbarui profil
                if ($conn->query($update_query) === TRUE) {
                    echo "Profil berhasil diperbarui";
                    header("Location: profile.php");
                    exit();
                } else {
                    echo "Error: " . $update_query . "<br>" . $conn->error;
                }
            } else {
                echo "Gagal mengunggah foto profil.";
                exit();
            }
        } else {
            // Persiapkan query untuk memperbarui profil tanpa foto profil
            $update_query = "UPDATE users SET name='$name', bio='$bio', username='$username' WHERE id='$user_id'";

            // Eksekusi query untuk memperbarui profil
            if ($conn->query($update_query) === TRUE) {
                $_SESSION['profile_update_success'] = "Profile berhasil diperbarui";
                header("Location: profile.php");
                exit();
            } else {
                echo "Error: " . $update_query . "<br>" . $conn->error;
            }
        }
    }
}
