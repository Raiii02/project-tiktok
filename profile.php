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
                  <img src="photo/avatar.jpg" width="30px" alt="" />
                </div>
                <div class="text-profile">
                  <h1>qiamxlyaa_</h1>
                  <h6>Kia⋆.ೃ࿔</h6>
                  <button class="btn-profile"> Upload</button>
                </div>
              </div>
              <div class="info-number">
                <div class="number-profile">
                  <h3>364</h3>
                  <p>Mengikuti</p>
                </div>
                <div class="number-profile">
                  <h3>31.6M</h3>
                  <p>Pengikut</p>
                </div>
                <div class="number-profile">
                  <h3>364.4M</h3>
                  <p>Suka</p>
                </div>
              </div>
              <div class="bio-profile">
                <h2>❥Dancer
                  Business/Sponsors: loremipsum@loremip.com
                  Support our dance team:
                </h2>
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
                    <div class="video-container">
                      <div class="video-card">
                        <div class="video-tiktok">
                          <video id="myVideo1" width="320" height="240">
                            <source src="src/assets/video/video1.mp4" type="video/mp4">
                            Browser Anda tidak mendukung tag video
                          </video>
                        </div>
                        <div class="video-description">
                          <p>Judul Video 1</p>
                        </div>
                        <div class="view-count">
                          <i class="fa-solid fa-play"></i>
                          <strong>1.74M</strong>
                        </div>
                      </div>
                      <div class="video-card">
                        <div class="video-tiktok">
                          <video id="myVideo1" width="320" height="240">
                            <source src="src/assets/video/video1.mp4" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                          </video>
                        </div>
                        <div class="video-description">
                          <p id="video-description-content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae facilis dignissimos numqua</p>
                        </div>
                        <div class="view-count">
                          <i class="fa-solid fa-play"></i>
                          <strong>1.74M</strong>
                        </div>
                      </div>
                      <div class="video-card">
                        <div class="video-tiktok">
                          <video id="myVideo1" width="320" height="240">
                            <source src="src/assets/video/video1.mp4" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                          </video>
                        </div>
                        <div class="video-description">
                          <p id="video-description-content">quia cumque optio vel veniam, nam cupiditate error unde quaerat nostrum recusandae libero.</p>
                        </div>
                        <div class="view-count">
                          <i class="fa-solid fa-play"></i>
                          <strong>1.74M</strong>
                        </div>
                      </div>
                      <div class="video-card">
                        <div class="video-tiktok">
                          <video id="myVideo1" width="320" height="240">
                            <source src="src/assets/video/video1.mp4" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                          </video>
                        </div>
                        <div class="video-description">
                          <p>Lorem, ipsum dolor sit amet consecteturCumque sint nulla quam.</p>
                        </div>
                        <div class="view-count">
                          <i class="fa-solid fa-play"></i>
                          <strong>1.74M</strong>
                        </div>
                      </div>
                      <div class="video-card">
                        <div class="video-tiktok">
                          <video id="myVideo1" width="320" height="240">
                            <source src="src/assets/video/video1.mp4" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                          </video>
                        </div>
                        <div class="video-description">
                          <p id="video-description-content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae facilis dignissimos numqua</p>
                        </div>
                        <div class="view-count">
                          <i class="fa-solid fa-play"></i>
                          <strong>1.74M</strong>
                        </div>
                      </div>
                    </div>
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
    </div>
    </div>
  </content>
  <script src="src/js/script.js"></script>
</body>

</html>