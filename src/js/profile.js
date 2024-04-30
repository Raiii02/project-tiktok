function openTab(tabId) {
  var tabs = document.querySelectorAll(".tab");
  tabs.forEach(function (tab) {
    tab.classList.remove("active");
  });

  var tabContents = document.querySelectorAll(".tab-content");
  tabContents.forEach(function (tabContent) {
    tabContent.classList.remove("active");
  });

  var selectedTab = document.getElementById(tabId);
  selectedTab.classList.add("active");
  var selectedTabContent = document.getElementById("panel-" + tabId.slice(4));
  selectedTabContent.classList.add("active");
}

window.onload = function () {
  openTab("tab-1");
};
document.addEventListener("DOMContentLoaded", function () {
  const firstVideo = document.querySelector(".video-container video");
  if (firstVideo) {
    firstVideo.muted = true;
    firstVideo.play();
  }
});
document
  .querySelectorAll(".video-container video")
  .forEach((video, index, videos) => {
    video.muted = true; // Mute all videos
    video.addEventListener("ended", () => {
      const nextIndex = (index + 1) % videos.length;
      videos[nextIndex].play();
    });
  });

document
  .querySelectorAll(".video-container video")
  .forEach((video, index, videos) => {
    let isMouseOver = false;

    video.addEventListener("mouseenter", () => {
      isMouseOver = true;
      videos.forEach((v, i) => {
        if (i !== index) {
          v.pause();
          v.currentTime = 0;
        }
      });
      video.play();
    });

    video.addEventListener("mouseleave", () => {
      isMouseOver = false;
      let videoArray = Array.from(videos);
      if (videoArray.some((v) => v.contains(document.activeElement))) {
        video.pause();
        video.currentTime = 0;
      }
    });
  });

const videoDescriptions = document.querySelectorAll(".video-description p"); // Mengubah selector
const maxLength = 28; // Jumlah maksimum karakter yang diinginkan
videoDescriptions.forEach((description) => {
  if (description.textContent.length > maxLength) {
    const trimmedDescription =
      description.textContent.substr(0, maxLength) + "...";
    description.textContent = trimmedDescription;
  }
});

var modalProfile = document.getElementById("modal");
var btn = document.getElementById("editButton");
var closeElements = document.querySelectorAll(".close, #close");

closeElements.forEach(function (element) {
  element.addEventListener("click", function () {
    modalProfile.style.display = "none";
  });
});

btn.onclick = function () {
  modalProfile.style.display = "block";

  // Lakukan permintaan AJAX untuk mendapatkan data profil
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_profile.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var profileData = JSON.parse(xhr.responseText);
      // Isi nilai input dengan data profil
      document.getElementById("username").value = profileData.username;
      document.getElementById("name").value = profileData.name;
      document.getElementById("bio").value = profileData.bio;
      document.getElementById("profileImage").src = profileData.profile_picture;
    }
  };
  xhr.send();
};

var fileInput = document.getElementById("profile_picture");
var profileImage = document.getElementById("profileImage");
fileInput.addEventListener("change", function (event) {
  var file = event.target.files[0];
  var imageURL = URL.createObjectURL(file);

  profileImage.src = imageURL;
});

var updateButton = document.querySelector(
  "#updateProfileForm button[type='submit']"
);
var inputs = document.querySelectorAll(
  "#updateProfileForm input[type='text'], #updateProfileForm textarea"
);
var profilePictureInput = document.getElementById("profile_picture");

// Variabel untuk menyimpan nilai awal input
var initialInputValues = {};

// Simpan nilai awal input saat halaman dimuat
inputs.forEach(function (input) {
  initialInputValues[input.id] = input.value.trim();
});

// Tambahkan event listener untuk input file foto profil
profilePictureInput.addEventListener("change", function () {
  updateButtonStatus();
});

// Fungsi untuk memeriksa apakah ada perubahan pada nilai input
function checkInputChange() {
  return Array.from(inputs).some(function (input) {
    // Periksa apakah ada perubahan pada input teks atau textarea
    if (input.type === "text" || input.tagName === "TEXTAREA") {
      if (input.value.trim() !== initialInputValues[input.id]) {
        return true;
      }
    }
    // Periksa apakah ada perubahan pada foto profil
    if (input.type === "file") {
      if (checkProfilePictureChange()) {
        return true;
      }
    }
    return false;
  });
}

// Fungsi untuk memeriksa apakah ada perubahan pada foto profil
function checkProfilePictureChange() {
  // Ambil foto profil yang dipilih oleh pengguna
  var file = profilePictureInput.files[0];
  return !!file;
}

// Fungsi untuk memeriksa apakah ada input teks yang kosong
function checkEmptyTextInputs() {
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].type === "text" && !inputs[i].value.trim()) {
      return true; // Jika ada input teks yang kosong, kembalikan true
    }
  }
  return false; // Jika tidak ada input teks yang kosong, kembalikan false
}

// Fungsi untuk mengubah status tombol Update dan warnanya
function updateButtonStatus() {
  if (!checkInputChange() || checkEmptyTextInputs()) {
    updateButton.disabled = true;
    updateButton.style.backgroundColor = "gray";
  } else {
    updateButton.disabled = false; // Aktifkan tombol Update
    updateButton.style.backgroundColor = "rgba(254, 44, 85, 1)"; // Kembalikan warna tombol menjadi biru (default)
  }
}

// Panggil fungsi updateButtonStatus untuk memastikan status tombol Update saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  updateButtonStatus();

  // Tambahkan event listener untuk setiap input
  inputs.forEach(function (input) {
    input.addEventListener("input", updateButtonStatus);
  });
});

function checkUsernameAvailability(username) {
  // Kirim permintaan AJAX untuk memeriksa apakah username sudah digunakan sebelumnya
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "check_username.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var response = xhr.responseText;
      if (response == "used") {
        document.getElementById("username_error").innerHTML =
          "Username sudah digunakan";
      } else {
        document.getElementById("username_error").innerHTML = "";
      }
    }
  };
  xhr.send("username=" + username);
}

// Tambahkan event listener untuk memeriksa username saat pengguna memasukkan input
document.getElementById("username").addEventListener("input", function () {
  var username = this.value;
  if (username.trim() !== "") {
    checkUsernameAvailability(username);
  } else {
    document.getElementById("username_error").innerHTML = "";
  }
});

document.addEventListener("keydown", function (event) {
  const key = event.key;
  const videos = document.querySelectorAll("video");

  function isInputActive() {
    const focusedElement = document.activeElement;
    return (
      focusedElement.tagName === "INPUT" ||
      focusedElement.tagName === "TEXTAREA"
    );
  }

  if (isInputActive()) {
    return;
  }

  const searchInput = document.querySelector(".form-control");
  const isSearchInputFocused = document.activeElement === searchInput;
  if (isSearchInputFocused) {
    return;
  }

  const modal = document.getElementById("modal-container");
  if (modal) {
    const modalStyle = window.getComputedStyle(modal);
    if (modalStyle.display === "block") {
      return;
    }
  }

  // Periksa tombol yang ditekan
  switch (key) {
    case "m":
    case "M":
      // Jika tombol 'm' ditekan, atur video menjadi dimute
      videos.forEach((video) => {
        video.muted = !video.muted;
      });
      break;
    default:
      break;
  }
});

var successModal = document.getElementById("modal-success");
var spanSuccess = document.getElementsByClassName("close-success")[0];

spanSuccess.onclick = function () {
  successModal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modalError) {
    successModal.style.display = "none";
  }
};

setTimeout(function () {
  successModal.style.display = "none";
}, 3000);
