<?php

include './src/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']);

if ($isLoggedIn) {
  // Lakukan query untuk mendapatkan data pengguna
  $user_id = $_SESSION['id'];
  $userQuery = "SELECT profile_picture FROM users WHERE id = $user_id";
  $userResult = $conn->query($userQuery);

  if ($userResult && $userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $profile_picture = $userData['profile_picture'];
  }
}

?>

<div class="header">
  <div class="center-header">
    <div class="logo">
      <img src="src/assets/photo/logotiktok.svg" height="29px" alt="" />
    </div>
    <div class="search">
      <input type="text" class="form-control" placeholder="Find accounts and videos..." />
      <button class="btn-search">
        <i class="fa fa-search"></i>
      </button>
    </div>
    <div class="service">

      <?php if ($isLoggedIn) { ?>

        <div class="upload">
          <button onclick="window.location.href='upload.php'"><i class="fas fa-plus"></i> Upload</button>
        </div>

        <div class="message">
          <i class="far fa-paper-plane"></i>
        </div>

        <div class="lotify">
          <i class="far fa-envelope"></i>
        </div>

        <div class="avatar">
          <div>
            <img src="<?php echo $profile_picture; ?>" width="30px" alt="">
            <div class="profile">
              <div class="profile-content">
                <a href="profile.php"><i class="far fa-user"></i><span>See Profile</span></a>
                <a><i class="fab fa-tiktok"></i><span></span>Get Coins</span></a>
                <a><i class="fas fa-cog"></i><span></span>Settings</span></a>
                <a><i class="fas fa-language"></i><span></span>French</span></a>
                <a><i class="fas fa-question"></i><span></span>Feedback and Support</span></a>
                <a><i class="fas fa-keyboard"></i><span></span>Keywords Shortcuts</span></a>
                <div class="border-profile-bottom"></div>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span></span>LogOut</span></a>
              </div>
            </div>
          </div>
        </div>

      <?php } else { ?>

        <div class="login">
          <button id="logIn-btn">Log in</button>
        </div>

        <div id="modal-container" class="modal-container">
          <div class="modal-content">
            <div class="container-login" id="logIn-form">
              <div class="form-login">
                <form method="post" action="logIn.php">
                  <span class="close">&times;</span>
                  <h2>Log In</h2>
                  <div class="form-group">
                    <strong>Email atau nama pengguna</strong>
                    <input type="text" name="username_email" id="username_email" placeholder="Email or Username" required>
                    <div id="username_email_error" class="error"></div>
                  </div>
                  <div class="form-group">
                    <input type="password" id="loginPassword" name="password" placeholder="Password" required>
                    <i class="fas fa-eye toggle-password" id="log-iconPass" data-icon="1"></i>
                    <div id="loginPasswordError" class="error"></div>
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
                    <hr>
                    <div class="bottom-text">
                      <span>Belum punya akun? <a id="signUp-btn">Daftar</a></span>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="container-signup" id="signUp-form">
              <span class="close">&times;</span>
              <form method="post" action="signUp.php">
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
                  
                </div>
                <div id="birthday-error" style="display: none; color: red;">Anda harus berusia minimal 18 tahun untuk mendaftar.</div>
                <div class="form-group">
                  <input type="email" id="email" name="email" placeholder="Email" required>
                  <div id="emailError" class="error"></div>
                  <input type="text" id="name" name="name" placeholder="Name" required>
                  <div id="nameError" class="error"></div>
                  <input type="password" id="password" name="password" placeholder="Password" required>
                  <i class="fas fa-eye toggle-password" id="icon-password" data-icon="2"></i>
                  <div id="passwordError" class="error"></div>
                  <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                  <i class="fas fa-eye toggle-password" id="icon-Cpassword" data-icon="3"></i>
                  <div id="confirmPasswordError" class="error"></div>
                </div>

                <button type="submit" name="submit" class="btnSignup">Sign Up</button>
                <div class="syarat-ketentuan">
                  <p>
                    Dengan menggunakan akun yang berlokasi di <span>Indonesia</span>, Anda menyetujui <span>Ketentuan Penggunaan</span> kami
                    dan menyatakan bahwa Anda telah membaca <span>Kebijakan Privasi</span> kami.
                  </p>
                </div>
                <div class="container-link">
                  <hr>
                  <div class="bottom-text">
                    <span>Sudah Punya Akun?
                      <a id="login-from-signup-btn">Masuk</a>
                    </span>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      <?php } ?>

    </div>
  </div>
</div>

<div id="modal-error" class="modal <?php echo (isset($_SESSION['email_exists']) || isset($_SESSION['password_incorrect']) || isset($_SESSION['username_email_dne'])) ? 'show' : ''; ?>">
  <div class="modal-content-error">
    <span class="close-error">&times;</span>
    <div id="error-message">
      <?php
      if (isset($_SESSION['email_exists'])) {
        echo "<i class='fas fa-exclamation-circle'></i><h1>Oppss!</h1> " . $_SESSION['email_exists'];
        unset($_SESSION['email_exists']);
      }
      if (isset($_SESSION['password_incorrect'])) {
        echo "<i class='fas fa-exclamation-circle'></i><h1>Oppss!</h1> " . $_SESSION['password_incorrect'];
        unset($_SESSION['password_incorrect']);
      }
      if (isset($_SESSION['username_email_dne'])) {
        echo "<i class='fas fa-exclamation-circle'></i><h1>Oppss!</h1> " . $_SESSION['username_email_dne'];
        unset($_SESSION['username_email_dne']);
      }
      ?>
    </div>
  </div>
</div>