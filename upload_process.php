<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan koneksi ke database
include "./src/config/config.php";

$user_id = $_SESSION['id'];

// Periksa apakah formulir sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah langkah kedua, yang berarti mengisi deskripsi
    if (isset($_GET['step']) && $_GET['step'] == 2) {

        if (isset($_POST['cancel'])) {
            // Tangkap path video dari sesi
            $video_path = $_SESSION['video_path'];

            // Hapus video yang diunggah
            if (unlink($video_path)) {
                // Jika penghapusan berhasil, unset path video dari sesi
                unset($_SESSION['video_path']);
                // Redirect kembali ke halaman upload
                header("Location: upload.php");
                exit();
            } else {
                // Jika penghapusan gagal, tampilkan pesan kesalahan
                echo "Gagal menghapus video.";
                exit();
            }
        }

        // Periksa apakah data yang dibutuhkan tersedia
        if (isset($_POST['description'])) {
            // Tangkap data dari formulir
            $description = $_POST['description'];

            // Tangkap path video dari sesi
            if (isset($_SESSION['video_path'])) {
                $video_path = $_SESSION['video_path'];
                $sql = "INSERT INTO videos ( user_id, video_path, description) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $user_id, $video_path, $description);
                if ($stmt->execute()) {
                    // Jika query berhasil dieksekusi, redirect ke halaman utama atau feed video
                    unset($_SESSION['video_path']);
                    header("Location: index.php");
                    exit();
                } else {
                    // Jika query gagal dieksekusi, tampilkan pesan kesalahan
                    echo "Error: " . $stmt->error;
                    exit();
                }
            } else {
                // Jika path video tidak tersedia dalam sesi, alihkan pengguna kembali ke halaman yang sesuai
                header("Location: upload.php");
                exit();
            }
        } else {
            // Jika data yang dibutuhkan tidak tersedia, Anda dapat mengalihkan pengguna kembali ke langkah sebelumnya atau menampilkan pesan kesalahan
            echo "Data yang diperlukan tidak lengkap";
            exit();
        }
    } else {
        // Jika bukan langkah kedua, tangani proses unggah video di sini
        // Tangkap data video yang diunggah
        $video = $_FILES["video"];

        // Periksa apakah file diunggah
        if ($video["error"] === 0) {
            // Tentukan direktori unggahan
            $uploadDir = "uploads/videos/";

            $sql_username = "SELECT username FROM users WHERE id = ?";
            $stmt_username = $conn->prepare($sql_username);
            $stmt_username->bind_param("i", $user_id);
            $stmt_username->execute();
            $result_username = $stmt_username->get_result();
            $row_username = $result_username->fetch_assoc();
            $username = $row_username['username'];
            $unique_id = substr(uniqid(), 0, 5);

            // Generate nama file unik
            $fileName = $unique_id . "_" . $username . "_" . basename($video["name"]);

            // Tentukan path unggahan
            $video_path = $uploadDir . $fileName;

            // Pindahkan file yang diunggah ke direktori unggahan
            if (move_uploaded_file($video["tmp_name"], $video_path)) {
                // Simpan nama file dan pathnya ke sesi
                $_SESSION['video_path'] = $video_path;

                // Redirect ke langkah kedua untuk mengisi deskripsi
                header("Location: upload.php?step=2");
                exit();
            } else {
                echo "Error uploading file.";
                exit();
            }
        } else {
            echo "Error: " . $video["error"];
            exit();
        }
    }
} else {
    // Jika formulir tidak disubmit, alihkan pengguna kembali ke halaman yang sesuai
    header("Location: upload.php");
    exit();
}
