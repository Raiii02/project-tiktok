<?php
include 'src/config/config.php';
session_start();

// Query data dari database
$sql = "SELECT videos.*, users.username, users.name, users.profile_picture FROM videos JOIN users ON videos.user_id = users.id";

$result = $conn->query($sql);

// Mengambil semua baris hasil query dan menyimpannya dalam sebuah array
$rows = array();
while ($row = $result->fetch_assoc()) {
  $rows[] = $row;
}

// Mengacak urutan array
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
  <link rel="icon" type="image/png" href="photo/icontiktok.jpg" />
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
          <?php
          foreach ($rows as $row) {
          ?>
            <!-- Mulai perulangan untuk setiap video -->
            <div class="content-right">
              <div class="avatar">
                <img src="src/assets/photo/evondev.jpg" width="55px" alt="">
              </div>
              <div class="content-playlist">
                <div class="playlist-info">
                  <div class="playlist-info-name">
                    <div class="name-user"><?php echo $row['username']; ?><img src="photo/tichxanh.jpg" width="13px" height="13px" alt="">
                      <div class="nickname">Evon.dev</div>
                    </div>
                  </div>
                  <button class="subscribe">Subscribe</button>
                  <div class="info-video">
                    <span><?php echo $row['description']; ?><span class="hagtag">#learnontiktok #evondev #laptrinh #frontend #it #dev</span>
                    </span>
                  </div>
                  <div class="link-music">
                    <i class="fas fa-music"></i>
                    <span>&nbsp;nhạc nền - evon.dev</span>
                  </div>
                </div>
                <div class="playlist-video">
                  <div class="video-tiktok">
                    <video height="500px" controls>
                      <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                    </video>
                  </div>
                  <div class="interactive">
                    <div class="heart" id="heart">
                      <i class="fas fa-heart"></i>
                    </div>
                    <span>10.0M</span>
                    <a href="detail-vid.php">
                      <div class="comment">
                        <i class="fas fa-comment-dots"></i>
                      </div>
                    </a>
                    <span>200.3K</span>
                    <div class="share">
                      <i class="fas fa-share"></i>
                    </div>
                    <span>10.5K</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Akhir perulangan untuk setiap video -->
          <?php } ?>
        </div>
      </div>
    </div>
  </content>

  <script src="src/js/script.js"></script>
</body>

</html>