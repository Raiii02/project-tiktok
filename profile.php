<?php
include './src/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SERVER['REQUEST_URI'])) {
  $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
}

$isLoggedIn = isset($_SESSION['id']);

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : (isset($_SESSION['id']) ? $_SESSION['id'] : null);

$userQuery = "SELECT * FROM users WHERE id = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("i", $user_id);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult && $userResult->num_rows > 0) {
  $userData = $userResult->fetch_assoc();
  $profile_picture = $userData['profile_picture'];
  $username = $userData['username'];
  $name = $userData['name'];
  $bio = $userData['bio'];

  $videoQuery = "SELECT videos.id AS id, videos.video_path, videos.description FROM videos JOIN users ON videos.user_id = users.id WHERE videos.user_id = ?";
  $videoStmt = $conn->prepare($videoQuery);
  $videoStmt->bind_param("i", $user_id);
  $videoStmt->execute();
  $videoResult = $videoStmt->get_result();

  $sql_count_subscribed = "SELECT COUNT(*) AS total_subscribed FROM subscriptions WHERE user_id = $user_id";
  $count_subscribed_result = $conn->query($sql_count_subscribed);

  if ($count_subscribed_result) {
    $total_subscribed = $count_subscribed_result->fetch_assoc()['total_subscribed'];
  } else {
    $total_subscribed = 0;
  }

  $subscribed_suffix = $total_subscribed > 1000000 ? 'M' : ($total_subscribed > 1000 ? 'K' : '');
  $total_subscribed_formatted = $total_subscribed >= 1000 ? number_format($total_subscribed / 1000, 1) . $subscribed_suffix : $total_subscribed;

  $sql_count_subscriber = "SELECT COUNT(*) AS total_subscriber FROM subscriptions WHERE subscriber_id = $user_id";
  $count_subscriber_result = $conn->query($sql_count_subscriber);

  if ($count_subscriber_result) {
    $total_subscriber = $count_subscriber_result->fetch_assoc()['total_subscriber'];
  } else {
    $total_subscriber = 0;
  }

  $subscriber_suffix = $total_subscriber > 1000000 ? 'M' : ($total_subscriber > 1000 ? 'K' : '');
  $total_subscriber_formatted = $total_subscriber >= 1000 ? number_format($total_subscriber / 1000, 1) . $subscriber_suffix : $total_subscriber;

  $sql_count_likes = "SELECT COUNT(*) AS total_likes FROM likes WHERE user_id = $user_id";
  $count_likes_result = $conn->query($sql_count_likes);

  if ($count_likes_result) {
    $total_likes = $count_likes_result->fetch_assoc()['total_likes'];
  } else {
    $total_likes = 0;
  }

  $like_suffix = $total_likes > 1000000 ? 'M' : ($total_likes > 1000 ? 'K' : '');
  $total_likes_formatted = $total_likes >= 1000 ? number_format($total_likes / 1000, 1) . $like_suffix : $total_likes;

  if ($videoResult && $videoResult->num_rows > 0) {
    $rows = array();
    while ($row = $videoResult->fetch_assoc()) {
      $viewed_user_id = isset($_GET['user_id']) ? $_GET['user_id'] : (isset($_SESSION['id']) ? $_SESSION['id'] : null);
      $isSubscribed = false;

      // Periksa apakah pengguna yang sedang masuk berlangganan pengguna yang sedang dilihat
      if ($isLoggedIn && isset($_GET['user_id']) && $_SESSION['id'] != $_GET['user_id']) {
        $subscriber_id = $_SESSION['id'];
        $subscription_sql = "SELECT * FROM subscriptions WHERE subscriber_id = $subscriber_id AND user_id = ?";
        $subscription_stmt = $conn->prepare($subscription_sql);
        $subscription_stmt->bind_param("i", $viewed_user_id);
        $subscription_stmt->execute();
        $subscription_result = $subscription_stmt->get_result();
        $isSubscribed = $subscription_result && $subscription_result->num_rows > 0;
      }
      $row['isSubscribed'] = $isSubscribed;

      $rows[] = $row;
    }
  }

  $is_logged_in_user = isset($_SESSION['id']) && $_SESSION['id'] == $user_id;
} else {
  echo "Error: Pengguna tidak ditemukan.";
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
  <link rel="stylesheet" href="src/style/style.css" />
  <link rel="icon" type="image/png" href="src/assets/photo/icontiktok.jpg" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="center-content-profile">
          <div class="content-profile">
            <div class="profile">
              <div class="header-profile">
                <div class="avatar">
                  <img src="<?php echo $profile_picture; ?>" width="30px" alt="" />
                </div>
                <div class="text-profile">
                  <h1><?php echo $username; ?></h1>
                  <h6><?php echo $name; ?></h6>
                  <?php if ($is_logged_in_user) : ?>
                    <button id="editButton" class="btn-profile-edit">Edit</button>
                  <?php else : ?>
                    <button id="subscribeButton" class="btn-profile <?php echo $isSubscribed ? 'subscribed' : ''; ?>" onclick="toggleSubscribe(this, <?php echo $viewed_user_id; ?>)">
                      <?php echo $isSubscribed ? "Unsubscribe" : "Subscribe"; ?>
                    </button>
                  <?php endif; ?>
                </div>
              </div>
              <div class="info-number">
                <div class="number-profile">
                  <h3><?php echo $total_subscriber_formatted; ?></h3>
                  <p>Mengikuti</p>
                </div>
                <div class="number-profile">
                  <h3><?php echo $total_subscribed_formatted; ?></h3>
                  <p>Pengikut</p>
                </div>
                <div class="number-profile">
                  <h3><?php echo $total_likes_formatted; ?></h3>
                  <p>Suka</p>
                </div>
              </div>
              <div class="bio-profile">
                <?php
                if (!empty($bio)) {
                  echo "<h2>$bio</h2>";
                } else {
                  echo "<h2>Belum ada biodata</h2>";
                }
                ?>
              </div>
              <div class="button-profile">
                <div class="button-icon">
                  <i class="fa-solid fa-share"></i>
                </div>
                <div class="button-icon">
                  <p style="font-weight:900;">:</p>
                </div>
              </div>
            </div>
            <div class="profile-video">
              <div class="profile-video">
                <div class="container">
                  <div class="tabs">
                    <div class="tab" id="tab-1" onclick="openTab('tab-1')">Video</div>
                    <div class="tab" id="tab-2" onclick="openTab('tab-2')"><i class="fa-solid fa-lock"></i> Disukai</div>
                  </div>

                  <!-- Konten tab -->
                  <div id="panel-1" class="tab-content">
                    <?php if ($videoResult && mysqli_num_rows($videoResult) > 0) { ?>
                      <div class="video-container">
                        <?php foreach ($rows as $index => $row) { ?>
                          <div class="video-card">
                            <a href='detail-vid.php?video_id=<?php echo $row['id']; ?>&prev_video_id=<?php echo ($index > 0) ? $rows[$index - 1]['id'] : null; ?>&next_video_id=<?php echo ($index < count($rows) - 1) ? $rows[$index + 1]['id'] : null; ?>&randomVideoIds=<?php echo urlencode(json_encode(array_column($rows, 'id'))); ?>'>
                              <div class="video-tiktok">
                                <video id="video" class="video" width="320" height="240">
                                  <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                                  Browser Anda tidak mendukung tag video
                                </video>
                              </div>
                            </a>
                            <div class="video-description">
                              <p><?php echo $row['description']; ?></p>
                            </div>
                            <div class="view-count">
                              <i class="fa-solid fa-play"></i>
                              <strong>1.74M</strong>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                  <div id="panel-2" class="tab-content">
                    <div class="disukai-container">
                      <i class="fa-solid fa-lock"></i>
                      <h1>Video yang disukai pengguna ini bersifat privat</h1>
                      <p>
                        Video yang disukai oleh demivangent saat ini tersembunyi</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="modal" class="modal-profile">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Update Profile</h2>
          <form id="updateProfileForm" action="update_profile.php" method="post" enctype="multipart/form-data">
            <div class="profile-image-edit">
              <img id="profileImage" src="" alt="Profile Picture" width="100">
              <input type="file" id="profile_picture" name="profile_picture">
            </div>
            <label>Username:</label>
            <input type="text" id="username" name="username" required>
            <div id="username_error" class="error"></div>
            <label>Name:</label>
            <input type="text" id="name" name="name" required>
            <label>Bio:</label>
            <textarea id="bio" name="bio"></textarea>
            <div class="button-group">
              <button type="submit" class="submit">Update</button>
              <button id="close" name="cancel">Batal</button>
            </div>
          </form>
        </div>
      </div>

      <div id="modal-success" <?php echo (isset($_SESSION['profile_update_success'])) ? 'style="display: block;"' : ''; ?>>
        <div class="modal-content-success">
          <span class="close-success">&times;</span>
          <div id="success-message">
            <?php
            if (isset($_SESSION['profile_update_success'])) {
              echo "<i class='fas fa-check-circle'></i><h1>Success!</h1> " . $_SESSION['profile_update_success'];
              unset($_SESSION['profile_update_success']);
            }
            ?>
          </div>
        </div>
      </div>

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

  </content>
  <script src="src/js/profile.js"></script>
  <script src="src/js/login.js"></script>
  <?php if (!empty($success_message)) : ?>
    <script>
      window.addEventListener('load', (event) => {
        var successModal = document.getElementById("successModal");
        successModal.style.display = "block";

        setTimeout(function() {
          successModal.style.display = "none";
        }, 3000);
      });
    </script>
  <?php endif; ?>
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
  </script>
</body>

</html>