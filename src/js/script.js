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

document.addEventListener("DOMContentLoaded", function () {
  // Fungsi untuk mengarahkan pengguna ke halaman baru saat video diklik
  var myVideo1 = document.getElementById("myVideo1");
  if (myVideo1) {
    myVideo1.addEventListener("click", function () {
      window.location.href = "index.html"; // Ganti "index.html" dengan URL halaman baru yang ingin Anda tuju
    });
  } else {
    console.error("Elemen dengan ID myVideo1 tidak ditemukan.");
  }

  // Fungsi untuk mengelola video TikTok
  const videos = document.querySelectorAll(".video-tiktok video");
  videos.forEach((video) => {
    video.muted = true; // Untuk mematikan suara video
    video.setAttribute("playsinline", ""); // Untuk mendukung autoplay di beberapa peramban mobile

    video.parentElement.addEventListener("mouseenter", function () {
      video.play(); // Memainkan video saat mouse masuk ke area video
    });

    video.parentElement.addEventListener("mouseleave", function () {
      video.pause(); // Memberhentikan video saat mouse meninggalkan area video
    });
  });

  // Memotong teks deskripsi video jika lebih panjang dari yang diinginkan
  const videoDescriptions = document.querySelectorAll(".video-description p"); // Mengubah selector
  const maxLength = 25; // Jumlah maksimum karakter yang diinginkan
  videoDescriptions.forEach((description) => {
    if (description.textContent.length > maxLength) {
      const trimmedDescription =
        description.textContent.substr(0, maxLength) + "...";
      description.textContent = trimmedDescription;
    }
  });

  // Membuka tab pertama secara otomatis saat halaman dimuat
  document.getElementById("tab-1").click();
});

// Deklarasi elemen-elemen modal, tombol, dan span
const modal = document.getElementById("modal-container");
const btn = document.getElementById("login-btn");
const span = document.querySelector(".close");
const signUpBtn = document.getElementById("signUp-btn");
const logInBtn = document.getElementById("logIn-btn");
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

// Event listener untuk tombol login
btn.addEventListener("click", showLoginModal);

// Event listener untuk tombol sign up di dalam modal login
logInBtn.addEventListener("click", showLoginModal);

// Event listener untuk tombol sign up di dalam modal login
signUpBtn.addEventListener("click", showSignUpModal);

// Event listener untuk tombol close modal
span.addEventListener("click", hideModal);

// Event listener untuk menutup modal saat klik di luar modal, tetapi bukan pada tombol close
window.addEventListener("click", function (event) {
  if (event.target === modal && !event.target.closest(".modal-login")) {
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

// Fungsi untuk memvalidasi password
function validatePassword() {
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirm-password");
  const passwordError = document.getElementById("password-error");

  const password = passwordInput.value;
  const confirmPassword = confirmPasswordInput.value;
  const passwordPattern = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}/;

  if (password === "") {
    passwordError.style.display = "none";
    return true;
  }

  if (!passwordPattern.test(password)) {
    passwordError.textContent =
      "Kata sandi harus memiliki setidaknya 8 karakter, setidaknya satu huruf besar, satu huruf kecil, dan satu angka";
    passwordError.style.display = "block";
    return false;
  }

  if (password !== confirmPassword && confirmPassword !== "") {
    passwordError.textContent = "Konfirmasi password tidak cocok!";
    passwordError.style.display = "block";
    return false;
  }

  passwordError.style.display = "none";

  return true;
}

// Event listener untuk input password
const passwordInput = document.getElementById("password");
const confirmPasswordInput = document.getElementById("confirm-password");

passwordInput.addEventListener("input", () =>
  setTimeout(validatePassword, 3000)
);
confirmPasswordInput.addEventListener("input", validatePassword);

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
