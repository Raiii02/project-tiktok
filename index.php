<?php
include 'src/config/config.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$isLoggedIn = isset($_SESSION['id']);

if (isset($_SERVER['REQUEST_URI'])) {
  $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
}

$sql = "SELECT videos.*, users.username, users.name, users.profile_picture FROM videos JOIN users ON videos.user_id = users.id";

if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id'];
  $sql .= " WHERE videos.user_id != $user_id";
}

$result = $conn->query($sql);

$rows = array();
while ($row = $result->fetch_assoc()) {
  $video_id = $row['id'];
  if (isset($_SESSION['id'])) {
    $user_ids = $_SESSION['id'];

    $like_sql = "SELECT like_count FROM likes WHERE user_id = $user_ids AND video_id = $video_id";
    $like_result = $conn->query($like_sql);

    if ($like_result && $like_result->num_rows > 0) {
      $like_data = $like_result->fetch_assoc();
      $like_count = $like_data['like_count'];

      $isLiked = $like_count > 0 ? true : false;
    } else {
      $isLiked = false;
    }

    $subscription_sql = "SELECT * FROM subscriptions WHERE subscriber_id = $user_ids AND user_id = " . $row['user_id'];
    $subscription_result = $conn->query($subscription_sql);
    $isSubscribed = $subscription_result && $subscription_result->num_rows > 0;
  } else {
    $isLiked = false;
    $isSubscribed = false;
  }

  $row['isLiked'] = $isLiked;
  $row['isSubscribed'] = $isSubscribed;

  $sql_count_likes = "SELECT COUNT(*) AS like_count FROM likes WHERE video_id = $video_id";
  $count_likes_result = $conn->query($sql_count_likes);

  if ($count_likes_result) {
    $total_likes = $count_likes_result->fetch_assoc()['like_count'];
    $like_suffix = $total_likes > 1000000 ? 'M' : ($total_likes > 1000 ? 'K' : '');
    $total_likes_formatted = $total_likes >= 1000 ? number_format($total_likes / 1000, 1) . $like_suffix : $total_likes;
  } else {
    $total_likes_formatted = 0;
  }
  $row['total_likes'] = $total_likes_formatted;


  $sql_count_comments = "SELECT COUNT(*) AS comment_count FROM comments WHERE video_id = $video_id";
  $count_comments_result = $conn->query($sql_count_comments);

  if ($count_comments_result) {
    $total_comments = $count_comments_result->fetch_assoc()['comment_count'];
    $comment_suffix = $total_comments > 1000000 ? 'M' : ($total_comments > 1000 ? 'K' : '');
    $total_comments_formatted = $total_comments >= 1000 ? number_format($total_comments / 1000, 1) . $comment_suffix : $total_comments;
  } else {
    $total_comments_formatted = 0;
  }
  $row['total_comments'] = $total_comments_formatted;

  $rows[] = $row;
}
shuffle($rows);

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body key="jaki">
  <header>
    <?php include 'components/navbar.php' ?>
  </header>
  <content>
    <div class="content">
      <div class="center-content">
        <div class="center-content-left">
          <?php include 'components/sidebar.php' ?>
        </div>
        <div class="center-content-right">
          <?php foreach ($rows as $index => $row) { ?>
            <div class="content-right">
              <div class="avatar">
                <a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
                  <img src="<?php echo $row['profile_picture']; ?>" width="55px" alt="">
                </a>
              </div>
              <div class="content-playlist">
                <div class="playlist-info">
                  <div class="playlist-info-name">
                    <a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
                      <div class="name-user"><?php echo $row['username']; ?>
                        <div class="nickname"><?php echo $row['name']; ?></div>
                      </div>
                    </a>
                  </div>
                  <button class="subscribe <?php echo $row['isSubscribed'] ? 'subscribed' : ''; ?>" onclick="toggleSubscribe(this, <?php echo $row['user_id']; ?>)">
                    <?php echo $row['isSubscribed'] ? "Unsubscribe" : "Subscribe"; ?>
                  </button>
                  <div class="info-video">
                    <span><?php echo $row['description']; ?></span>
                  </div>
                  <div class="link-music">
                    <i class="fas fa-music"></i>
                    <span>&nbsp; original sound - <?php echo $row['username']; ?></span>
                  </div>
                </div>
                <div class="playlist-video">
                  <div class="video-tiktok">
                    <video height="500px" controls data-video-id="<?php echo $row['id']; ?>">
                      <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                    </video>
                  </div>
                  <div class="interactive">
                    <div class="heart" id="heart">
                      <button class="like-dislike-button <?php echo $row['isLiked'] ? 'active' : ''; ?>" onclick="toggleLike(this, <?php echo $row['id']; ?>)">
                        <i class="fas fa-heart" style="color: <?php echo $row['isLiked'] ? 'red' : 'gray'; ?>"></i>
                      </button>
                    </div>
                    <span class="total-likes" id="totalLikes"><?php echo $row['total_likes']; ?></span>
                    <a href='detail-vid.php?video_id=<?php echo $row['id']; ?>&prev_video_id=<?php echo ($index > 0) ? $rows[$index - 1]['id'] : null; ?>&next_video_id=<?php echo ($index < count($rows) - 1) ? $rows[$index + 1]['id'] : null; ?>&randomVideoIds=<?php echo urlencode(json_encode(array_column($rows, 'id'))); ?>'>
                      <div class="comment">
                        <i class="fas fa-comment-dots"></i>
                      </div>
                    </a>
                    <span><?php echo $row['total_comments']; ?></span>
                    <div class="share">
                      <i class="fas fa-share"></i>
                    </div>
                    <span>10.5K</span>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </content>

  <div id="modal-error-subs" class="modal">
    <div class="modal-content-error">
      <span class="close-error-subs">&times;</span>
      <div id="error-message">
        <i class='fas fa-exclamation-circle'></i>
        <h1>Oppss!</h1>
        Please log in to subscribe.
      </div>
    </div>
  </div>

  <script src="src/js/index.js"></script>
  <script src="src/js/login.js"></script>
  <script>
    function toggleSubscribe(button, userId) {
      const isSubscribed = !button.classList.contains('subscribed');
      const modalError = document.getElementById('modal-error-subs');

      if (!isLoggedIn()) {
        console.error('User is not logged in.');
        // Tampilkan modal error
        modalError.style.display = 'block';
        setTimeout(() => {
          modalError.style.display = 'none';
        }, 3000); // Sembunyikan modal setelah 3 detik
        return; // Hentikan eksekusi fungsi
      }

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'subscribe.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      const data = `user_id=${userId}&is_subscribed=${isSubscribed}`;
      xhr.onload = function() {
        if (xhr.status === 200) {
          const responseData = JSON.parse(xhr.responseText);
          if (isSubscribed) {
            button.textContent = 'Unsubscribe';
            button.classList.add('subscribed');
          } else {
            button.textContent = 'Subscribe';
            button.classList.remove('subscribed');
          }
        } else {
          console.error('Failed to toggle subscribe: Server returned status ' + xhr.status);
        }
      };
      xhr.send(data);
    }



    function isLoggedIn() {
      return <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
    }


    function toggleLike(button, videoId) {
      const isLiked = button.classList.contains('active');
      const heartIcon = button.querySelector('i');

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'like.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      const data = `video_id=${videoId}&is_liked=${!isLiked}`;
      xhr.onload = function() {
        if (xhr.status === 200) {
          const responseData = JSON.parse(xhr.responseText);
          const totalLikesElement = button.closest('.interactive').querySelector('.total-likes');
          if (!isLiked) {
            button.classList.add('active');
            heartIcon.style.color = 'red';
            totalLikesElement.textContent = parseInt(totalLikesElement.textContent) + 1;
          } else {
            button.classList.remove('active');
            heartIcon.style.color = 'gray';
            totalLikesElement.textContent = parseInt(totalLikesElement.textContent) - 1;
          }
        } else {
          console.error('Failed to toggle like.');
        }
      };
      xhr.send(data);
    }
  </script>
</body>

</html>