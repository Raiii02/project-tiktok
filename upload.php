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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TikTok</title>
  <link rel="stylesheet" href="src/style/style.css">
  <link rel="stylesheet" href="style/css/responsive.css">
  <link rel="icon" type="image/png" href="photo/icontiktok.jpg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
  
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
        <div class="content-main-center">
          <div class="center-content-upload">
            <div class="content-upload" id="uploadContainer">
              <div class="upload-main">
                <center>
                  <h2>Logo</h2>
                  <h4><b>Pilih video untuk diunggah</b></h4>
                  <p>Pilih video untuk diunggah</p>
                  <h5><b>Untuk mengedit video, gunakan Google Chrome atau Microsoft Edge</b></h5>
                  <br>
                  <h5>MP4 atau WebM <br> Resolusi 720x1280 atau lebih tinggi <br> Maks. 10 menit <br> Kurang dari 2 GB</h5>
                  <input type="file" id="videoFile" accept="video/*" onchange="checkFile()">
                  
                  <div id="loadingIcon" style="display: none;">
                    Loading...
                  </div>
                  <button id="uploadButton"  style="display: none;"  class="btnUnggah" onclick="uploadVideo()">Unggah</button>
                </center>
              </div>
            </div>
          </div>
          <div class="center-content-upload" id="videoInfoForm" style="display: none">
            <div  class="content-upload">
              <div class="judul-content-upload">
                <h3><b>Unggah Video</b></h3>
                <p>Posting video ke akun Anda</p>
              </div>
              <form id="infoForm">
                <label for="">Keterangan uploadVideo</label>
                <input type="text" id="videoTitle" placeholder="Judul Video" >
                <label for="">Sampul Video</label>
                <input type="file" id="thumbnailFile" accept="image/*" placeholder="Unggah Thumbnail">
                <label for="">Tambahkan Ke Playlist</label><br>
                <select id="visibility">
                  <option value="public">Publik</option>
                  <option value="friends">Teman</option>
                  <option value="private">Privat</option>
                </select><br>
                <label for="">Siapa yang dapat menonton</label><br>
                <select id="visibility">
                  <option value="public">Publik</option>
                  <option value="friends">Teman</option>
                  <option value="private">Privat</option>
                </select><br>
                <div class="container-buttonUpload">
                  <button type="button" class="button-batal-video" onclick="cancelUpload()">Buang</button>
                  <button type="submit" class="button-upload-video">Posting</button>
                </div>
              </form>
            </div>
          </div>
          <div class="center-content-upload">
            <div class="content-upload">
              <div class="alert-tiktok">
                <div class="text-alert">
                  <h4>Buat video berkualitas tinggi di CapCut Online</h4>
                  <p>Persingkat video Anda secara otomatis dan buat video dari naskah dengan fitur yang didukung AI.</p>
                </div>
                <button class="btn-alert-upload"><i></i>Coba Sekarang</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </content>
  <script src="src/js/js.js"></script>
  <script>
    function uploadVideo() {
      // Implement logic to upload video
      // After successful upload, display video info form and add uploaded video to the list
      document.getElementById("uploadContainer").style.display = "none";
      document.getElementById("videoInfoForm").style.display = "block";
    }

    function cancelUpload() {
      // Implement logic to cancel upload and reset form
      document.getElementById("uploadContainer").style.display = "block";
      document.getElementById("videoInfoForm").style.display = "none";
    }
  </script>
</body>
</html>
