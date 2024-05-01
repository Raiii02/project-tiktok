<?php
include 'src/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SERVER['REQUEST_URI'])) {
  $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
}

// Query data dari database
$sql = "SELECT videos.*, users.username, users.name, users.profile_picture FROM videos JOIN users ON videos.user_id = users.id";

$result = $conn->query($sql);

$rows = array();
while ($row = $result->fetch_assoc()) {
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
        <div class="center-content-jelajahi">
          <div class="content-jelajahi">
            <div class="wrapper">
              <div class="icon">
                <i id="left" class="fa-solid fa-angle-left"></i>
              </div>
              <ul class="tabs-box">
                <li class="tab">Coding</li>
                <li class="tab active">JavaScript</li>
                <li class="tab">Podcasts</li>
                <li class="tab">Databases</li>
                <li class="tab">Web Development</li>
                <li class="tab">Unboxing</li>
                <li class="tab">History</li>
                <li class="tab">Programming</li>
                <li class="tab">Gadgets</li>
                <li class="tab">Algorithms</li>
                <li class="tab">Comedy</li>
                <li class="tab">Gaming</li>
                <li class="tab">Share Market</li>
                <li class="tab">Smartphones</li>
                <li class="tab">Data Structure</li>
              </ul>
              <div class="icon"><i id="right" class="fa-solid fa-angle-right"></i>
              </div>
            </div>
          </div>
          <div class="container-jelajahi">
            <div class="grid-container">
              <?php foreach ($rows as $index => $row) { ?>
                <div class="jalajah-card">
                  <div class="jelajahi-video-tiktok">
                    <a href='detail-vid.php?video_id=<?php echo $row['id']; ?>&prev_video_id=<?php echo ($index > 0) ? $rows[$index - 1]['id'] : null; ?>&next_video_id=<?php echo ($index < count($rows) - 1) ? $rows[$index + 1]['id'] : null; ?>&randomVideoIds=<?php echo urlencode(json_encode(array_column($rows, 'id'))); ?>'>
                      <video class="video">
                        <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                      </video>
                      <div class="jelajahi-count">
                        <i class="fa-solid fa-play"></i>
                        <strong>1.74M</strong>
                      </div>
                    </a>
                  </div>
                  <div class="jelajahi-description">
                    <p class="jelajahi-description-content"><?php echo $row['description']; ?></p>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </content>
  <script src="src/js/jelajahi.js"></script>
  <script src="src/js/login.js"></script>
</body>

</html>