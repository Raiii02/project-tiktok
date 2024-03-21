<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
  $isLoggedIn = true;
} else {
  $isLoggedIn = false;
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
  <link rel="icon" type="image/png" href="photo/icontiktok.jpg" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body key="jaki">
  <header>
    <?php include 'components/navbar.php' ?>

    <div id="modal-container" class="modal-container">
      <div class="modal-content">
        <div class="container-login">
          <div class="form-login">
            
            <form id="logIn-form" method="post" action="logIn.php">
              <span class="close">&times;</span>
              <h2>Log In</h2>
              <div class="form-group">
                <strong>Email atau nama pengguna</strong>
                <input type="text" name="username_email" id="username_email" placeholder="Email or Username" required>
              </div>
              <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fas fa-eye toggle-password"></i>
              </div>
              <div class="password">
                <a href="#">Lupa password?</a>
              </div>
              <button class="btnLogin" type="submit" name="submit">Log in</button>
              <div class="syarat-ketentuan">
                <p>
                  Dengan menggunakan akun yang berlokasi di <span>Indonesia</span>, Anda menyetujui <span>Ketentuan Penggunaan</span> kami 
                  dan menyatakan bahwa Anda telah membaca <span>Kebijakan Privasi</span> kami.
                </p>
              </div>
              <div class="container-link">
                <hr>~
                <div class="bottom-text">
                  <span>Belum punya akun? <a href="#" id="signUp-btn">Daftar</a></span>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="container-signup">

          <span class="close">&times;</span>
          <form id="signUp-form" method="post" action="signUp.php">
            <h2>Sign Up</h2>
            <div class="birthday-picker">
              <select id="month" name="month" onchange="updateDays()">
                <option value="" disabled selected>Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="010">October</option>
                <option value="011">November</option>
                <option value="012">December</option>
              </select>
              <select id="day" name="day" onchange="updateDays()">
                <option value="" disabled selected>Day</option>
                <!-- Pilihan tanggal akan diisi secara dinamis oleh JavaScript -->
              </select>
              <select id="year" name="year" onchange="updateDays()">
                <option value="" disabled selected>Year</option>
                <!-- Pilihan tahun akan diisi secara dinamis oleh JavaScript -->
              </select>
              <div id="birthday-error" style="display: none; color: red;">Anda harus berusia minimal 18 tahun untuk mendaftar.</div><br>
            </div>
            <div class="form-group">
              <input type="email" name="email" placeholder="Email" required>
              <input type="text" name="username" placeholder="Username" required>
              <input type="password" id="password" name="password" placeholder="Password" required>
              <i class="fas fa-eye toggle-password" id="icon-password"></i>
              <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
              <i class="fas fa-eye toggle-password" id="icon-Cpassword"></i>
            </div>
            <div id="password-error" style="display: none; color: red;">Konfirmasi password tidak cocok!</div><br>
            <button type="submit" name="submit" class="btnSignup">Sign Up</button>
            
              <div class="container-link">
                <div class="bottom-text">
                  <span>Sudah Punya Akun?
                    <a id="logIn-btn">Log In</a>
                  </span>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>

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
                  <div class="name-user">Evon.devvv <img src="photo/tichxanh.jpg" width="13px" height="13px" alt="">
                    <div class="nickname">Evon.dev</div>
                  </div>
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
                    <source src="./src/assets/video/video1.mp4" type="video/mp4">
                  </video>
                </div>
                <div class="interactive">
                  <div class="heart" id="heart1" onclick="clickheart()">
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