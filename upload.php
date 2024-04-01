<?php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    $isLoggedIn = true;
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
} else {
    $isLoggedIn = false;
    $username = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Video</title>
</head>

<body>
    <h2>Unggah Video</h2>
    <form action="upload_process.php" method="POST" enctype="multipart/form-data">

        <label for="video">Pilih video:</label><br>
        <input type="file" id="video" name="video" accept="video/*" required><br><br>

        <label for="description">Deskripsi:</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br><br>

        <button type="submit" name="submit">Unggah</button>
    </form>
</body>

</html>