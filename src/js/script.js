function openTab(tabId) {
  // Menghapus kelas 'active' dari semua tab dan konten tab
  var tabs = document.querySelectorAll(".tab");
  tabs.forEach(function (tab) {
    tab.classList.remove("active");
  });

  var tabContents = document.querySelectorAll(".tab-content");
  tabContents.forEach(function (tabContent) {
    tabContent.classList.remove("active");
  });

  // Menambahkan kelas 'active' pada tab yang dipilih dan konten tab yang sesuai
  var selectedTab = document.getElementById(tabId);
  selectedTab.classList.add("active");
  var selectedTabContent = document.getElementById("panel-" + tabId.slice(4));
  selectedTabContent.classList.add("active");
}

// Ambil semua elemen video pada halaman
const videos = document.querySelectorAll("video");

// Fungsi untuk memulai ulang video
function restartVideo(video) {
  video.currentTime = 0;
  video.play();
}

// Fungsi untuk memulai video
function playVideo(video) {
  video.play();
}

// Fungsi untuk menghentikan video
function pauseVideo(video) {
  video.pause();
}

// Fungsi untuk mengatur pemutaran video berdasarkan visibilitas
function handleVideoVisibility(entries) {
  entries.forEach((entry) => {
    const video = entry.target;
    if (entry.intersectionRatio >= 0.7) {
      // Video terlihat lebih dari 70%, autoplay
      restartVideo(video);
    } else if (entry.intersectionRatio <= 0.7) {
      // Video terlihat kurang dari 70%, pause
      pauseVideo(video);
    }
  });
}

// Buat observer untuk mengamati elemen video
const videoObserver = new IntersectionObserver(handleVideoVisibility, {
  threshold: [0, 0.7],
});

// Tambahkan observer untuk setiap video
videos.forEach((video) => {
  videoObserver.observe(video);
});

// Tambahkan event listener ended pada setiap video
videos.forEach((video) => {
  video.addEventListener("ended", function () {
    restartVideo(video); // Mulai ulang video setelah selesai diputar
  });
});

// Fungsi untuk memulai ulang video
function restartVideo(video) {
  video.currentTime = 0; // Set waktu putar ke awal
  video.play(); // Mulai ulang video
}

// Event listener untuk menangkap peristiwa scroll
window.addEventListener("scroll", function () {
  // Periksa visibilitas video saat menggulir
  handleVideoVisibility(videoObserver.takeRecords());
});

// Otomatis putar video yang sedang ditampilkan saat halaman dimuat ulang
window.addEventListener("load", function () {
  handleVideoVisibility(videoObserver.takeRecords());
});

// Auto mute semua video
videos.forEach((video) => {
  video.muted = true;
});

// Fungsi untuk mengecek apakah video terlihat lebih dari 70% dari tinggi layar
function isInViewport(element) {
  var rect = element.getBoundingClientRect();
  var viewportHeight =
    window.innerHeight || document.documentElement.clientHeight;
  var visibleHeight =
    Math.min(viewportHeight, rect.bottom) - Math.max(0, rect.top);
  var visiblePercentage = visibleHeight / rect.height;
  return visiblePercentage >= 0.7;
}

// Event listener untuk menangkap tombol yang ditekan pada dokumen
document.addEventListener("keydown", function (event) {
  const key = event.key;
  const videos = document.querySelectorAll("video");

  // Periksa tombol yang ditekan
  switch (key) {
    case " ":
      // Jika tombol spasi ditekan, hentikan pemutaran video
      event.preventDefault(); // Menghentikan perilaku default dari spasi (scrolling)
      for (var i = 0; i < videos.length; i++) {
        var video = videos[i];
        if (isInViewport(video)) {
          if (video.paused) {
            video.play();
          } else {
            video.pause();
          }
          break;
        }
      }
      break;
    case "m":
    case "M":
      // Jika tombol 'm' ditekan, atur video menjadi dimute
      videos.forEach((video) => {
        video.muted = !video.muted;
      });
      break;
    case "ArrowDown":
      // Jika tombol panah bawah ditekan, scroll ke bawah
      window.scrollBy(0, 1000); // Anda dapat menyesuaikan angka 100 sesuai kebutuhan
      break;
    case "ArrowUp":
      // Jika tombol panah atas ditekan, scroll ke atas
      window.scrollBy(0, -1000); // Anda dapat menyesuaikan angka 100 sesuai kebutuhan
      break;
    default:
      break;
  }

  // Jika tombol panah atas atau panah bawah ditekan
  if (key === "ArrowUp" || key === "ArrowDown") {
    const currentScrollPosition = window.scrollY;
    const windowHeight = window.innerHeight;
    const scrollOffset = key === "ArrowUp" ? -windowHeight : windowHeight;

    // Scroll ke atas atau ke bawah satu layar penuh
    window.scrollTo({
      top: currentScrollPosition + scrollOffset,
      behavior: "smooth",
    });
  }
});

// Memotong teks deskripsi video jika lebih panjang dari yang diinginkan
const videoDescriptions = document.querySelectorAll(".info-video span"); // Mengubah selector
const maxLength = 50; // Jumlah maksimum karakter yang diinginkan
videoDescriptions.forEach((description) => {
  if (description.textContent.length > maxLength) {
    const trimmedDescription =
      description.textContent.substr(0, maxLength) + "...";
    description.textContent = trimmedDescription;
  }
});

//PROFILE DAN JELAJAHI
document.addEventListener("DOMContentLoaded", function () {
  const videos = document.querySelectorAll(".video");

  let timeout;

  videos.forEach((video) => {
    video.addEventListener("mouseover", function () {
      const self = this;
      clearTimeout(timeout);
      timeout = setTimeout(function () {
        if (!self.paused) return;
        self.play();
      }, 1000); // Ganti angka 1000 dengan delay dalam milidetik yang diinginkan
    });

    video.addEventListener("mouseout", function () {
      clearTimeout(timeout);
      if (this.paused) return;
      this.pause();
    });

    video.addEventListener("ended", function () {
      const nextVideoContainer = this.parentElement.nextElementSibling;
      if (nextVideoContainer) {
        const nextVideo = nextVideoContainer.querySelector(".video");
        nextVideo.play();
      }
    });
  });
});

// Deklarasi elemen-elemen modal, tombol, dan span
const modal = document.getElementById("modal-container");
const span = document.querySelector(".close");
const signUpBtn = document.getElementById("signUp-btn");
const logInBtn = document.getElementById("logIn-btn");
const signUptoLogIn = document.getElementById("login-from-signup-btn");
const logInForm = document.getElementById("logIn-form");
const signUpForm = document.getElementById("signUp-form");

// Fungsi untuk menampilkan modal login
function showLoginModal() {
  logInForm.style.display = "block";
  signUpForm.style.display = "none";
  modal.style.display = "block";
}

// Fungsi untuk menampilkan modal sign up
function showSignUpModal() {
  logInForm.style.display = "none";
  signUpForm.style.display = "block";
  modal.style.display = "block";
}

// Fungsi untuk menyembunyikan modal saat tombol close diklik
function hideModal() {
  modal.style.display = "none";
}

// Event listener untuk tombol sign up di dalam modal login
logInBtn.addEventListener("click", showLoginModal);

// Event listener untuk tombol sign up di dalam modal login
signUpBtn.addEventListener("click", showSignUpModal);

signUptoLogIn.addEventListener("click", showLoginModal);

// Event listener untuk tombol close modal
span.addEventListener("click", hideModal);

// Event listener untuk menutup modal saat klik di luar modal, tetapi bukan pada tombol close
window.addEventListener("click", function (event) {
  if (event.target === modal && !event.target.closest(".modal-container")) {
    hideModal();
  }
});

// Fungsi untuk memperbarui opsi hari pada dropdown tanggal
function updateDays() {
  const daySelect = document.getElementById("day");
  const monthSelect = document.getElementById("month");
  const yearSelect = document.getElementById("year");
  const selectedMonth = monthSelect.value;

  // Simpan nilai hari sebelumnya
  let previousDay = daySelect.value;
  daySelect.innerHTML = "";

  // Tambahkan opsi placeholder
  const placeholderOption = document.createElement("option");
  placeholderOption.value = "";
  placeholderOption.disabled = true;
  placeholderOption.selected = true;
  placeholderOption.textContent = "Tanggal";
  daySelect.appendChild(placeholderOption);

  // Tentukan jumlah hari dalam bulan yang dipilih
  const selectedYear = yearSelect.value;
  let daysInMonth;

  if (selectedMonth === "02") {
    daysInMonth =
      selectedYear % 4 === 0 &&
        (selectedYear % 100 !== 0 || selectedYear % 400 === 0)
        ? 29
        : 28;
  } else if (["04", "06", "09", "11"].includes(selectedMonth)) {
    daysInMonth = 30;
  } else {
    daysInMonth = 31;
  }

  // Tambahkan opsi hari ke dalam dropdown tanggal
  for (let i = 1; i <= daysInMonth; i++) {
    appendOption(daySelect, i);
  }

  // Kembalikan nilai hari ke nilai sebelumnya jika memungkinkan
  if (previousDay) {
    daySelect.value = previousDay;
  }
}

// Event listener saat dokumen dimuat
document.addEventListener("DOMContentLoaded", () => {
  const daySelect = document.getElementById("day");
  const yearSelect = document.getElementById("year");
  const currentYear = new Date().getFullYear();

  // Tambahkan opsi untuk hari dan tahun
  for (let i = 1; i <= 31; i++) {
    appendOption(daySelect, i);
  }

  for (let i = currentYear; i >= currentYear - 100; i--) {
    appendOption(yearSelect, i);
  }

  // Perbarui opsi hari saat dokumen dimuat
  updateDays();
});

// Fungsi untuk menambahkan opsi pada dropdown
function appendOption(select, value) {
  const option = document.createElement("option");
  option.value = value < 10 ? "0" + value : value;
  option.textContent = value;
  select.appendChild(option);
}

// Fungsi untuk mengubah visibilitas kata sandi
function togglePasswordVisibility(inputField, icon) {
  const type =
    inputField.getAttribute("type") === "password" ? "text" : "password";
  inputField.setAttribute("type", type);
  icon.classList.toggle("fa-eye-slash");
}

// Event listener untuk mengubah visibilitas kata sandi ketika ikon diklik
document.querySelectorAll(".toggle-password").forEach((icon) => {
  icon.addEventListener("click", () => {
    const inputField = icon.previousElementSibling;
    togglePasswordVisibility(inputField, icon);
  });
});

/* VALIDASI */

//Fungsi untuk memvalidasi username_email
function validateInput() {
  const input = document.getElementById("username_email").value.trim();
  const errorElement = document.getElementById("username_email_error");

  if (input === "") {
    // Kosongkan pesan kesalahan jika input kosong
    errorElement.textContent = "Username atau email tidak boleh kosong";
  } else if (input.includes("@")) {
    // Jika input mengandung karakter @, itu mungkin adalah email
    if (!isValidEmail(input)) {
      errorElement.textContent = "Masukkan alamat email yang valid";
    } else {
      errorElement.textContent = "";
    }
  } else {
    // Tidak perlu validasi jika input bukan email
    errorElement.textContent = "";
  }
}

// Fungsi untuk memeriksa apakah input adalah email yang valid
function isValidEmail(email) {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(email);
}

// Panggil fungsi validasi saat input berubah
const usernameEmailInput = document.getElementById("username_email");
usernameEmailInput.addEventListener("input", () => {
  if (usernameEmailInput.value.length === 1) {
    validateInput();
  }
});
usernameEmailInput.addEventListener("blur", validateInput);

// Fungsi untuk memvalidasi nama
function validateName() {
  const nameInput = document.getElementById("name");
  const name = nameInput.value.trim(); // Menghapus spasi di awal dan akhir input
  const nameError = document.getElementById("nameError");
  if (name === "") {
    nameError.textContent = "Name harus diisi"; // Menampilkan pesan kesalahan jika input kosong
    return false;
  } else {
    nameError.textContent = ""; // Menghapus pesan kesalahan jika input tidak kosong
    return true;
  }
}

const nameInput = document.getElementById("name");
nameInput.addEventListener("input", () => {
  if (nameInput.value.length === 1) {
    validateName(); // Memvalidasi nama setelah satu karakter dimasukkan
  }
});
nameInput.addEventListener("blur", validateName);

//Fungsi untuk memvalidasi email
function validateEmail() {
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("emailError");
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  const email = emailInput.value;

  if (email === "") {
    emailError.textContent = "Email tidak boleh kosong";
    return false;
  }

  if (!emailPattern.test(email)) {
    setTimeout(() => {
      if (emailInput.value === email) {
        emailError.textContent = "Masukkan alamat email yang valid";
      }
    }, 1000);
  } else {
    emailError.textContent = ""; // Menghapus pesan kesalahan jika email valid
    return true;
  }
}

// Event listener untuk input email
const emailInput = document.getElementById("email");
emailInput.addEventListener("input", validateEmail); // Memeriksa status input email setiap kali pengguna memasukkan atau menghapus karakter
emailInput.addEventListener("blur", () => {
  if (emailInput.value === "") {
    validateEmail();
  }
});

// Validasi Password untuk Login
function validateLoginPassword() {
  const loginPasswordInput = document.getElementById("loginPassword");
  const loginPasswordError = document.getElementById("loginPasswordError");
  const password = loginPasswordInput.value;

  if (password === "") {
    loginPasswordError.textContent = "Password tidak boleh kosong";
    return false;
  }
  loginPasswordError.textContent = "";
}

// Event listener untuk input password
const loginPasswordInput = document.getElementById("loginPassword");
loginPasswordInput.addEventListener("input", () => {
  if (loginPasswordInput.value.length === 1) {
    validateLoginPassword();
  }
});
loginPasswordInput.addEventListener("blur", () => {
  if (loginPasswordInput.value === "") {
    validateLoginPassword();
  }
});

// Fungsi untuk memvalidasi password
function validatePasswordInput() {
  const passwordInput = document.getElementById("password");
  const passwordError = document.getElementById("passwordError");

  const password = passwordInput.value;
  const passwordPattern = /^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;

  if (password === "") {
    passwordError.textContent = "";
    return true;
  }

  if (!passwordPattern.test(password)) {
    passwordError.textContent =
      "Kata sandi harus memiliki setidaknya 6 karakter, setidaknya satu huruf besar, dan satu angka";
    return false;
  }

  passwordError.textContent = "";
  return true;
}

const passwordInput = document.getElementById("password");

passwordInput.addEventListener("blur", validatePasswordInput);

// Fungsi untuk memvalidasi konfirmasi password
function validateConfirmPasswordInput() {
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirm-password");
  const confirmPasswordError = document.getElementById("confirmPasswordError");

  const password = passwordInput.value;
  const confirmPassword = confirmPasswordInput.value;

  if (confirmPassword === "") {
    confirmPasswordError.textContent = "";
    return true;
  }

  if (password !== confirmPassword && confirmPassword !== "") {
    confirmPasswordError.textContent = "Konfirmasi password tidak cocok!";
    return false;
  }

  confirmPasswordError.textContent = "";
  return true;
}

// Event listener untuk input password
const confirmPasswordInput = document.getElementById("confirm-password");

confirmPasswordInput.addEventListener("input", validateConfirmPasswordInput);
confirmPasswordInput.addEventListener("blur", validateConfirmPasswordInput);

// Fungsi untuk memvalidasi tanggal lahir
function validateBirthday() {
  const dayInput = document.getElementById("day");
  const monthInput = document.getElementById("month");
  const yearInput = document.getElementById("year");
  const birthdayError = document.getElementById("birthday-error");

  const dayValue = dayInput.value;
  const monthValue = monthInput.value;
  const yearValue = yearInput.value;

  if (dayValue === "" || monthValue === "" || yearValue === "") {
    return;
  }

  const birthdate = new Date(yearValue, monthValue - 1, dayValue);
  const age = new Date().getFullYear() - birthdate.getFullYear();

  // Jika usia kurang dari 18 tahun, tampilkan pesan kesalahan
  birthdayError.style.display = age < 18 ? "block" : "none";
}

// Event listener untuk input tanggal lahir
const dayInput = document.getElementById("day");
const monthInput = document.getElementById("month");
const yearInput = document.getElementById("year");

[dayInput, monthInput, yearInput].forEach((input) =>
  input.addEventListener("input", validateBirthday)
);

//Pesan Error
var modalError = document.getElementById("modal-error");
var spanError = document.getElementsByClassName("close-error")[0];

spanError.onclick = function () {
  modalError.style.display = "none"; // Sembunyikan modal saat tombol "Close" diklik
};

window.onclick = function (event) {
  if (event.target == modalError) {
    modalError.style.display = "none";
  }
};

setTimeout(function () {
  modalError.style.display = "none";
}, 3000);
