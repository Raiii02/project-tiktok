<?php
include './src/config/config.php';

// Memeriksa apakah ada sesi yang aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $subscriber_id = $_SESSION['id'];

    // Memeriksa apakah permintaan adalah POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Periksa apakah data yang diperlukan telah diterima
        if (isset($_POST['user_id']) && isset($_POST['is_subscribed'])) {
            $user_id = $_POST['user_id'];
            $isSubscribed = $_POST['is_subscribed'];

            // Lakukan operasi sesuai dengan tindakan pengguna
            if ($isSubscribed == 'true') {
                // Jika pengguna ingin subscribe
                $sql_subscribe = "INSERT INTO subscriptions (subscriber_id, user_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql_subscribe);
                $stmt->bind_param("ii", $subscriber_id, $user_id);

                if ($stmt->execute()) {
                    // Subscribe berhasil disimpan
                    echo json_encode(['status' => 'success', 'message' => 'Subscribe berhasil']);
                } else {
                    // Gagal menyimpan subscribe
                    echo json_encode(['status' => 'error', 'message' => 'Gagal subscribe']);
                }
                $stmt->close();
            } else {
                // Jika pengguna ingin unsubscribe
                $sql_unsubscribe = "DELETE FROM subscriptions WHERE subscriber_id = ? AND user_id = ?";
                $stmt = $conn->prepare($sql_unsubscribe);
                $stmt->bind_param("ii", $subscriber_id, $user_id);

                if ($stmt->execute()) {
                    // Unsubscribe berhasil
                    echo json_encode(['status' => 'success', 'message' => 'Unsubscribe berhasil']);
                } else {
                    // Gagal melakukan unsubscribe
                    echo json_encode(['status' => 'error', 'message' => 'Gagal melakukan unsubscribe']);
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
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login untuk melakukan subscribe.']);
}
