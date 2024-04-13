<?php
include './src/config/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SERVER['HTTP_REFERER'])) {
    if (strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
        $_SESSION['previous_page'] = 'index.php';
    } elseif (strpos($_SERVER['HTTP_REFERER'], 'jelajahi.php') !== false) {
        $_SESSION['previous_page'] = 'jelajahi.php';
    } elseif (strpos($_SERVER['HTTP_REFERER'], 'jelajahi.php') !== false) {
        $_SESSION['previous_page'] = 'profile.php';
    }
} else {
    $_SESSION['previous_page'] = '';
}

// Memeriksa apakah parameter video_id disetel dan query berhasil dieksekusi
if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];

    $prev_video_id = $_GET['prev_video_id'];
    $next_video_id = $_GET['next_video_id'];
    $randomVideoIds = isset($_GET['randomVideoIds']) ? json_decode($_GET['randomVideoIds'], true) : array();

    $isLikedJSON = json_encode(false);

    // Query untuk mendapatkan data video berdasarkan ID
    $sql_video = "SELECT * FROM videos WHERE id = $video_id";
    $videoResult = $conn->query($sql_video);

    if ($videoResult->num_rows > 0) {
        $videoData = $videoResult->fetch_assoc();

        $randomVideoIdsJson = $_GET['randomVideoIds'] ?? '[]';
        $randomVideoIds = json_decode($randomVideoIdsJson, true);

        $current_index = array_search($video_id, $randomVideoIds);
        $prevVideoId = $current_index > 0 ? $randomVideoIds[$current_index - 1] : null;
        $nextVideoId = $current_index < count($randomVideoIds) - 1 ? $randomVideoIds[$current_index + 1] : null;

        $posted_at = $videoData['created_at'];

        $current_time = time();
        $uploaded_time = strtotime($posted_at);
        $time_diff = $current_time - $uploaded_time;
        $minutes_diff = floor($time_diff / 60);
        $hours_diff = floor($time_diff / (60 * 60));
        $days_diff = floor($time_diff / (60 * 60 * 24));
        $weeks_diff = floor($time_diff / (60 * 60 * 24 * 7));
        $months_diff = floor($time_diff / (60 * 60 * 24 * 30.44));

        if ($minutes_diff < 60) {
            $formatted_posted_at = "$minutes_diff menit yang lalu";
        } elseif ($hours_diff < 24) {
            $formatted_posted_at = "$hours_diff jam yang lalu";
        } elseif ($days_diff < 7) {
            $formatted_posted_at = "$days_diff hari yang lalu";
        } elseif ($weeks_diff < 4) {
            $formatted_posted_at = "$weeks_diff minggu yang lalu";
        } elseif ($months_diff < 12) {
            $formatted_posted_at = date('F j', $uploaded_time);
        } else {
            $formatted_posted_at = date('F Y', $uploaded_time);
        }
    } else {
        $error_message = "Tidak ada video yang ditemukan.";
    }

    $sql_user = "SELECT * FROM users WHERE id IN (SELECT user_id FROM videos WHERE id = $video_id)";
    $userResult = $conn->query($sql_user);

    $sql_comments = "SELECT * FROM comments WHERE video_id = $video_id";
    $commentResult = $conn->query($sql_comments);

    if ($commentResult && $commentResult->num_rows > 0) {
        $commentData = $commentResult->fetch_assoc();
        $current_time = time();
        $comment_uploaded_time = strtotime($commentData['created_at']);

        $time_diff = $current_time - $comment_uploaded_time;
        $hours_diff = floor($time_diff / (60 * 60));
        $days_diff = floor($time_diff / (60 * 60 * 24));
        $weeks_diff = floor($time_diff / (60 * 60 * 24 * 7));
        $months_diff = floor($time_diff / (60 * 60 * 24 * 30.44));

        if ($hours_diff < 24) {
            $formatted_comment_posted_at = $hours_diff . "j yang lalu";
        } elseif ($days_diff < 7) {
            $formatted_comment_posted_at = $days_diff . "h yang lalu";
        } elseif ($weeks_diff < 4) {
            $formatted_comment_posted_at = $weeks_diff . "m yang lalu";
        } elseif ($months_diff < 12) {
            $formatted_comment_posted_at = date('F j', $comment_uploaded_time);
        } else {
            $formatted_comment_posted_at = date('F Y', $comment_uploaded_time);
        }
    }


    $sql_count_likes = "SELECT COUNT(*) AS total_likes FROM likes WHERE video_id = $video_id";
    $count_likes_result = $conn->query($sql_count_likes);

    // Periksa apakah query berhasil dieksekusi
    if ($count_likes_result) {
        // Ambil jumlah total like jika query berhasil
        $total_likes = $count_likes_result->fetch_assoc()['total_likes'];
    } else {
        // Atur jumlah total like menjadi 0 jika query gagal
        $total_likes = 0;
    }

    $like_suffix = $total_likes > 1000000 ? 'M' : ($total_likes > 1000 ? 'K' : '');
    $total_likes_formatted = $total_likes >= 1000 ? number_format($total_likes / 1000, 1) . $like_suffix : $total_likes;

    $comment_suffix = $commentResult->num_rows > 1000000 ? 'M' : ($commentResult->num_rows > 1000 ? 'K' : '');
    $total_comments_formatted = $commentResult->num_rows >= 1000 ? number_format($commentResult->num_rows / 1000, 1) . $comment_suffix : $commentResult->num_rows;

    if ($videoResult->num_rows <= 0) {
        $error_message = "Tidak ada video yang ditemukan.";
    }
} else {
    // Jika parameter video_id tidak disetel, set pesan kesalahan
    $error_message = "Parameter video_id tidak ditemukan.";
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    if (isset($_POST['submit_comment'])) {
        // Ambil data yang dikirim dari formulir
        $comment_text = $_POST['comment_text'];
        $sql_insert_comment = "INSERT INTO comments (user_id, video_id, comment_text) VALUES ('$user_id', '$video_id', '$comment_text')";

        // Eksekusi query
        if ($conn->query($sql_insert_comment) === TRUE) {
            header("Location: detail-vid.php?video_id=$video_id");
            exit();
        } else {
            echo "Error: " . $sql_insert_comment . "<br>" . $conn->error;
        }
    }

    $like_sql = "SELECT like_count FROM likes WHERE user_id = $user_id AND video_id = $video_id";
    $like_result = $conn->query($like_sql);

    if ($like_result && $like_result->num_rows > 0) {
        $like_data = $like_result->fetch_assoc();
        $like_count = $like_data['like_count'];

        $isLiked = $like_count > 0 ? true : false;
    } else {
        $isLiked = false;
    }

    $isLikedJSON = json_encode($isLiked);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TikTok</title>
    <link rel="stylesheet" href="src/style/style.css" />
    <link rel="stylesheet" href="style/css/responsive.css" />
    <link rel="icon" type="image/png" href="src/assets/photo/icontiktok.jpg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body key="jaki">
    <content>
        <div class="container-detail-vid">
            <div class="content-vid">
                <!-- Video content -->
                <?php if ($videoResult && $videoResult->num_rows > 0) { ?>
                    <video controls>
                        <source src="<?php echo $videoData['video_path']; ?>" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                <?php } else { ?>
                    <p><?php echo isset($error_message) ? $error_message : "Tidak ada video yang ditemukan."; ?></p>
                <?php } ?>

                <div class="header-content">
                    <div class="warna-bayang"></div>
                    <div class="CloseBtn">&times;</div>
                    <div class="DetailVideoIcon"><i class="fa-solid fa-ellipsis"></i></div>
                    <div class="SearchBtn">
                        <div class="search">
                            <input type="text" class="form-control" id="inpSearch" placeholder="Find accounts and videos..." />
                            <button class="btn-search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="navigation">
                    <?php if (isset($prevVideoId)) { ?>
                        <div class="prevVideo">
                            <a href="detail-vid.php?video_id=<?php echo $prevVideoId; ?>&prev_video_id=<?php echo $prevVideoId; ?>&next_video_id=<?php echo $video_id; ?>&randomVideoIds=<?php echo urlencode(json_encode($randomVideoIds)); ?>">
                                <svg width="26" data-e2e="" height="26" viewBox="0 0 48 48" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M34.4142 22.5858L18.1213 6.29289C17.7308 5.90237 17.0976 5.90237 16.7071 6.29289L15.2929 7.70711C14.9024 8.09763 14.9024 8.7308 15.2929 9.12132L30.1716 24L15.2929 38.8787C14.9024 39.2692 14.9024 39.9024 15.2929 40.2929L16.7071 41.7071C17.0976 42.0976 17.7308 42.0976 18.1213 41.7071L34.4142 25.4142C35.1953 24.6332 35.1953 23.3668 34.4142 22.5858Z"></path>
                                </svg>
                            </a>
                        </div>
                    <?php } ?>

                    <!-- Tombol panah bawah -->
                    <?php if (isset($nextVideoId)) { ?>
                        <div class="nextVideo">
                            <a href="detail-vid.php?video_id=<?php echo $nextVideoId; ?>&prev_video_id=<?php echo $video_id; ?>&next_video_id=<?php echo $nextVideoId; ?>&randomVideoIds=<?php echo urlencode(json_encode($randomVideoIds)); ?>">
                                <svg width="26" data-e2e="" height="26" viewBox="0 0 48 48" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M34.4142 22.5858L18.1213 6.29289C17.7308 5.90237 17.0976 5.90237 16.7071 6.29289L15.2929 7.70711C14.9024 8.09763 14.9024 8.7308 15.2929 9.12132L30.1716 24L15.2929 38.8787C14.9024 39.2692 14.9024 39.9024 15.2929 40.2929L16.7071 41.7071C17.0976 42.0976 17.7308 42.0976 18.1213 41.7071L34.4142 25.4142C35.1953 24.6332 35.1953 23.3668 34.4142 22.5858Z"></path>
                                </svg>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="content-container">
                <div class="content-comments">
                    <div class="CommentList">
                        <div class="ProfileWrapper">
                            <?php if ($userResult && $userResult->num_rows > 0) {
                                while ($userData = $userResult->fetch_assoc()) { ?>
                                    <div class="CardProfile">
                                        <div class="Header">
                                            <div class="Avatar">
                                                <img src="<?php echo $userData['profile_picture']; ?>" width="55px" alt="">
                                            </div>
                                            <a href="profile.php" class="UserName">
                                                <span id="nama"><?php echo $userData['username']; ?></span><br><span id="bio"><?php echo $userData['name']; ?> . <?php echo $formatted_posted_at; ?></span>
                                            </a>
                                            <button class="ButtonFollow">Ikuti</button>
                                        </div>
                                        <div class="
                                        Detail">
                                            <?php if ($videoResult && $videoResult->num_rows > 0) {     ?>
                                                <div class="Caption">
                                                    <span><?php echo $videoData['description']; ?></span>
                                                </div>
                                                <div class="Songs">
                                                    <i class="fa-solid fa-music"></i> original sound - <?php echo $userData['username']; ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                            <div class="MainContent">
                                <div class="LayoutMain">
                                    <div class="count_sosmed">
                                        <div class="CountVideo">
                                            <div class="DetailCount">
                                                <div class="IconWrapper">
                                                    <button id="likeButton" class="like-dislike-button <?php echo $isLiked ? 'active' : ''; ?>" onclick="toggleLike()">
                                                        <i class="fas fa-heart" style="<?php echo $isLiked ? 'color: red;' : 'color: gray;'; ?>"></i>
                                                    </button>
                                                </div>
                                                <span id="totalLikes"><?php echo $total_likes_formatted; ?></span>
                                            </div>
                                            <div class="DetailCount">
                                                <div class="IconWrapper"><i class="fa-solid fa-comment-dots"></i></div>
                                                <span><?php echo $total_comments_formatted; ?></span>
                                            </div>
                                            <div class="DetailCount">
                                                <div class="IconWrapper"><i class="fa-solid fa-bookmark"></i></div>
                                                <span>176.7K</span>
                                            </div>
                                        </div>
                                        <div class="SosmedContent">
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                            <a href=""> <img src="photo/evondev.jpg" width="55px" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="LinkContainer">
                                        <p class="LinkText"> https://www.tiktok.com/@jonathan_abee/video/7343225896242777349?is_from_webapp=1&sender_device=pc&web_id=7286525911754900993</p>
                                        <button class="ButtonCopyLink">Salin Tautan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="TabMenuWrapper">
                            <div class="TabMenuContainer">
                                <div class="TabLink" onclick="openCity(event, 'Komentar')">
                                    <div class="TextTab">
                                        Komentar (<?php echo $total_comments_formatted; ?>)
                                    </div>
                                </div>
                                <div class="TabLink" onclick="openCity(event, 'VidKreator')">
                                    <div class="TextTab">Video Kreator</div>
                                </div>
                            </div>
                            <div class="SearchMenuTop">
                                <span>Cari :</span>
                                <div class="SpanWord">Hubungan Rungkad ? <i class="fa-solid fa-magnifying-glass"></i></div>
                            </div>
                        </div>
                        <div class="tabcon" id="Komentar">
                            <?php
                            if ($commentResult && $commentResult->num_rows > 0) {
                                while ($commentData = $commentResult->fetch_assoc()) {
                                    // Ambil user_id dari komentar
                                    $comment_user_id = $commentData['user_id'];
                                    // Query untuk mendapatkan data pengguna dari tabel users berdasarkan user_id
                                    $sql_user_info = "SELECT * FROM users WHERE id = $comment_user_id";
                                    $user_info_result = $conn->query($sql_user_info);
                                    if ($user_info_result && $user_info_result->num_rows > 0) {
                                        $user_info = $user_info_result->fetch_assoc();
                                        // Tampilkan foto profil dan username pengguna
                            ?>
                                        <div class="container-comment">
                                            <div class="content-comment">
                                                <div class="avatar">
                                                    <img src="<?php echo $user_info['profile_picture']; ?>" width="55px" alt="">
                                                </div>
                                                <div class="content-main">
                                                    <a href=""><?php echo $user_info['username']; ?></a>
                                                    <p><?php echo $commentData['comment_text']; ?></p>
                                                    <div class="subcoment">
                                                        <span><?php echo $formatted_comment_posted_at; ?></span>
                                                        <span class="Replybtn">Jawab</span>
                                                    </div>
                                                </div>
                                                <div class="count-like">

                                                </div>
                                            </div>
                                            <div class="reply-comment">
                                                <div class="TextReply">Lihat 431 balasan</div>
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            } else {
                                echo "<p>Belum ada komentar untuk video ini.</p>";
                            }
                            ?>
                        </div>
                        <div class="tabcon" id="VidKreator">
                            <div class="VideoKreator">
                                <?php
                                // Query untuk mendapatkan daftar video dari pengguna terkait
                                $sql_user_videos = "SELECT * FROM videos WHERE user_id = (SELECT user_id FROM videos WHERE id = $video_id)";
                                $user_videos_result = $conn->query($sql_user_videos);

                                // Periksa apakah query berhasil dieksekusi dan hasilnya tidak kosong
                                if ($user_videos_result && $user_videos_result->num_rows > 0) {
                                    // Tampilkan video-video dari pengguna terkait
                                    while ($user_video_data = $user_videos_result->fetch_assoc()) {
                                ?>
                                        <div class="video-wrapper">
                                            <a href="detail-vid.php?video_id=<?php echo $user_video_data['id']; ?>">
                                                <video src="<?php echo $user_video_data['video_path']; ?>"></video>
                                            </a>
                                            <div class="count">
                                                <i class="fa-solid fa-play"></i>
                                                <strong>1.74M</strong>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    // Tampilkan pesan jika tidak ada video dari pengguna terkait
                                    echo "<p>Tidak ada video dari pengguna terkait.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="BottomComment">
                    <div class="content-bottom">
                        <?php if (isset($_SESSION['id'])) { ?>
                            <form action="" method="post">
                                <div class="ComentInput">
                                    <input type="text" id="DivInput" name="comment_text" placeholder="Tambah Komentar">
                                    <div class="MentionWrapper">@</div>
                                </div>
                                <div class="PostButton">
                                    <button type="submit" name="submit_comment">Posting</button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <div class="ComentInput">
                                <span>Masuk untuk Berkomentar</span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </content>
    <script src="src/js/detail-vid.js"></script>
    <script>
        let isLiked = <?php echo $isLikedJSON; ?>;

        function toggleLike() {
            const likeButton = document.getElementById('likeButton');
            const heartIcon = likeButton.querySelector('i');
            const videoId = <?php echo json_encode($video_id); ?>;

            // Kirim permintaan AJAX ke server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'like.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Data yang dikirimkan ke server
            const data = `video_id=${videoId}&is_liked=${!isLiked}`;
            xhr.onload = function() {
                if (xhr.status === 200) {
                    isLiked = !isLiked;
                    if (isLiked) {
                        heartIcon.style.color = 'red';
                        document.getElementById('totalLikes').textContent = parseInt(document.getElementById('totalLikes').textContent) + 1; // Tambah 1 pada jumlah total like
                    } else {
                        heartIcon.style.color = 'gray';
                        document.getElementById('totalLikes').textContent = parseInt(document.getElementById('totalLikes').textContent) - 1; // Kurangi 1 dari jumlah total like
                    }
                } else {
                    console.error('Gagal menyimpan like ke server');
                }
            };
            xhr.send(data);
        }

        const videos = document.querySelectorAll(".content-vid video");
        videos.forEach(function(video) {
            video.addEventListener("ended", playNextVideo);
        });

        function playNextVideo() {
            window.location.href = 'detail-vid.php?video_id=<?php echo $nextVideoId; ?>&prev_video_id=<?php echo $video_id; ?>&next_video_id=<?php echo $nextVideoId; ?>&randomVideoIds=<?php echo urlencode(json_encode($randomVideoIds)); ?>';
        }

        var closeBtn = document.querySelector(".CloseBtn");

        closeBtn.addEventListener("click", function() {
            <?php if (isset($_SESSION['previous_page'])) : ?>
                window.location.href = '<?php echo $_SESSION['previous_page']; ?>';
            <?php endif; ?>
        });
    </script>


</body>

</html>