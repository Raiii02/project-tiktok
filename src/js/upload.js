function uploadVideo() {
  // Implement logic to upload video
  // After successful upload, display video info form and add uploaded video to the list
  document.getElementById("uploadContainer").style.display = "none";
  document.getElementById("videoInfoForm").style.display = "block";
}

// function cancelUpload() {
//   // Redirect ke upload.php tanpa parameter step=2
//   window.location.href = "upload.php";
// }
function checkFile() {
  var fileInput = document.getElementById("videoFile");
  var uploadButton = document.getElementById("uploadButton");
  var loadingIcon = document.getElementById("loadingIcon");

  // Tampilkan animasi loading
  loadingIcon.style.display = "block";

  // Simulasikan proses loading
  setTimeout(function () {
    if (fileInput.files.length > 0) {
      // Sembunyikan animasi loading dan tampilkan tombol unggah
      loadingIcon.style.display = "none";
      uploadButton.style.display = "block";
    }
  }, 1000); // Ganti nilai 2000 dengan waktu yang sesuai dengan proses loading nyata
}

function uploadVideo() {
  // Logika untuk mengunggah video
  console.log("Video diunggah!");
}
