<?php
include './src/config/config.php';

// Memeriksa apakah ada sesi yang aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Memeriksa apakah permintaan adalah POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Periksa apakah data yang diperlukan telah diterima
        if (isset($_POST['video_id']) && isset($_POST['is_liked'])) {
            $video_id = $_POST['video_id'];
            $isLiked = $_POST['is_liked'];

            // Lakukan operasi sesuai dengan tindakan pengguna
            if ($isLiked == 'true') {
                // Jika pengguna memberikan like
                $sql_insert_like = "INSERT INTO likes (user_id, video_id, like_count) VALUES (?, ?, 1)";
                $stmt = $conn->prepare($sql_insert_like);
                $stmt->bind_param("ii", $user_id, $video_id);

                if ($stmt->execute()) {
                    // Like berhasil disimpan
                    echo json_encode(['status' => 'success', 'message' => 'Like berhasil disimpan']);
                } else {
                    // Gagal menyimpan like
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan like']);
                }
                $stmt->close();
            } else {
                // Jika pengguna menghapus like
                $sql_delete_like = "DELETE FROM likes WHERE user_id = ? AND video_id = ?";
                $stmt = $conn->prepare($sql_delete_like);
                $stmt->bind_param("ii", $user_id, $video_id);

                if ($stmt->execute()) {
                    // Like berhasil dihapus
                    echo json_encode(['status' => 'success', 'message' => 'Like berhasil dihapus']);
                } else {
                    // Gagal menghapus like
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus like']);
                }
                $stmt->close();
            }
        } else {
            // Data yang diperlukan tidak diterima
            echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
        }
    } else {
        // Metode request yang diperbolehkan hanya POST
        echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
    }
} else {
    // Jika tidak ada sesi yang aktif
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login untuk melakukan like.']);
}
