<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TikTok - By Tuan Xu</title>
    <link rel="stylesheet" href="src/style/style.css" />
    <link rel="stylesheet" href="style/css/responsive.css" />
    <link rel="icon" type="image/png" href="photo/icontiktok.jpg" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
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
            <div class="content-right">
  <div class="avatar">
    <img src="photo/evondev.jpg" width="55px" alt="">
  </div>
  <div class="content-playlist">
    <div class="playlist-info">
      <div class="playlist-info-name">
        <div class="name-user">Evon.devvv <img src="photo/tichxanh.jpg" width="13px" height="13px" alt=""><div class="nickname">Evon.dev</div></div>
      </div>
      <button class="subscribe">Subscribe</button>
      <div class="info-video">
        <span>Để trở thành frontend developer thì cần học những gì?<span class="hagtag">#learnontiktok #evondev #laptrinh #frontend #it #dev</span>
        </span>
      </div>
      <div class="link-music">
        <i class="fas fa-music"></i>
        <span>&nbsp;nhạc nền - evon.dev</span>
      </div>
    </div>
    <div class="playlist-video">
      <div class="video-tiktok">
        <video height="500px" controls="playlist">
          <source src="./video/video1.mp4" type="video/mp4">
        </video>
      </div>
      <div class="interactive">
        <div class="heart" id ="heart1" onclick="clickheart()">
          <i class="fas fa-heart"></i>
        </div>
        <span>10.0M</span>
        <div class="comment">
          <i class="fas fa-comment-dots"></i>
        </div>
        <span>200.3K</span>
        <div class="share">
          <i class="fas fa-share"></i>
        </div>
        <span>10.5K</span>
      </div>
    </div>
  </div>
</div>

<!-- Dua bagian ini diulangi untuk setiap data dalam array -->
<!-- Anda dapat mengulangi kode ini untuk setiap objek dalam array "data" -->

          </div>
          </div>
        </div>
      </div>
    </content>
    <script src="src/js/script.js"></script>
  </body>
</html>