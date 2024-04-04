<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan koneksi ke database
include "./src/config/config.php";

// Periksa apakah formulir sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $video = $_FILES["video"];
    $description = $_POST["description"];
    $user_id = $_SESSION["id"]; // Diasumsikan Anda menyimpan user_id di sesi

    // Periksa apakah file diunggah
    if ($video["error"] === 0) {
        // Tentukan direktori unggahan
        $uploadDir = "uploads/videos/";

        // Generate nama file unik
        $fileName = uniqid() . "_" . basename($video["name"]);

        // Tentukan path unggahan
        $uploadPath = $uploadDir . $fileName;

        // Pindahkan file yang diunggah ke direktori unggahan
        if (move_uploaded_file($video["tmp_name"], $uploadPath)) {
            // Masukkan data video ke database
            $sql = "INSERT INTO videos ( user_id, video_path, description) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $user_id, $uploadPath, $description);
            if ($stmt->execute()) {
                // Redirect ke halaman utama atau feed video
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Error: " . $video["error"];
    }
}
