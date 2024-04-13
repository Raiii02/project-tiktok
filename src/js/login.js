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

document
  .querySelector(".container-signup .close")
  .addEventListener("click", hideModal);

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
  const emailPattern =
    /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|yahoo\.co\.id|hotmail\.com|outlook\.com|aol\.com|icloud\.com|protonmail\.com|yandex\.com|mail\.com|zoho\.com|gmx\.com)$/;
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
  const emailPattern =
    /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|yahoo\.co\.id|hotmail\.com|outlook\.com|aol\.com|icloud\.com|protonmail\.com|yandex\.com|mail\.com|zoho\.com|gmx\.com)$/;

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
emailInput.addEventListener("input", validateEmail);
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

  const password = passwordInput.value.trim(); // Menghapus spasi di awal dan akhir input
  const passwordPattern = /^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;

  if (password === "") {
    passwordError.textContent = "Kata sandi tidak boleh kosong";
    return false;
  }

  if (!passwordPattern.test(password)) {
    setTimeout(() => {
      if (passwordInput.value === password) {
        passwordError.textContent =
          "Kata sandi harus memiliki setidaknya 6 karakter, setidaknya satu huruf besar, dan satu angka";
      }
    }, 1000);
  } else {
    passwordError.textContent = ""; // Menghapus pesan kesalahan jika pola password terpenuhi
    return true;
  }
}

const passwordInput = document.getElementById("password");

passwordInput.addEventListener("input", validatePasswordInput);
passwordInput.addEventListener("blur", () => {
  if (passwordInput.value === "") {
    validatePasswordInput();
  }
});

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
  modalError.style.display = "none"; 
};

window.onclick = function (event) {
  if (event.target == modalError) {
    modalError.style.display = "none";
  }
};

setTimeout(function () {
  modalError.style.display = "none";
}, 3000);


