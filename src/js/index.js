window.onload = function () {
  const videos = document.querySelectorAll("video");

  videos.forEach(function (video) {
    video.addEventListener("click", function (event) {
      event.preventDefault();
    });

    video.addEventListener("dblclick", function (event) {
      event.preventDefault();
    });
  });
};
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

// Event listener untuk menangkap tombol yang ditekan pada dokumen
document.addEventListener("keydown", function (event) {
  const key = event.key;
  const videos = document.querySelectorAll("video");

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

  const searchInput = document.querySelector(".form-control");
  const isSearchInputFocused = document.activeElement === searchInput;
  if (isSearchInputFocused) {
    return;
  }

  const modal = document.getElementById("modal-container");
  if (modal) {
    const modalStyle = window.getComputedStyle(modal);
    if (modalStyle.display === "block") {
      return; // Exit the function if modal is visible
    }
  }
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
      window.scrollBy(0, 800); // Anda dapat menyesuaikan angka 100 sesuai kebutuhan
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

function changeSVGColor(svgElement, color) {
  svgElement.setAttribute("fill", color);
}

function checkURLForColorChange() {
  var currentURL = window.location.href;

  // Mendapatkan elemen ikon dan teks "foryou"
  var foryouIcon = document.querySelector(".foryou svg");
  var foryouText = document.querySelector(".foryou span.namehiden");

  var jelajahiIcon = document.querySelector(".live svg");
  var jelajahiText = document.querySelector(".live span.namehiden");

  if (
    currentURL === "http://localhost/project-tiktok/index.php" ||
    currentURL === "http://localhost/project-tiktok/"
  ) {
    changeSVGColor(foryouIcon, "rgba(254, 44, 85, 1)");
    foryouText.style.color = "rgba(254, 44, 85, 1.0)";
  } else {
    changeSVGColor(foryouIcon, "rgba(22, 24, 35, 1)");
    foryouText.style.color = "rgba(22, 24, 35, 1.0)";
  }

  if (currentURL === "http://localhost/project-tiktok/jelajahi.php") {
    changeSVGColor(jelajahiIcon, "rgba(254, 44, 85, 1)");
    jelajahiText.style.color = "rgba(254, 44, 85, 1.0)";
  } else {
    changeSVGColor(jelajahiIcon, "rgba(22, 24, 35, 1)");
    jelajahiText.style.color = "rgba(22, 24, 35, 1.0)";
  }
}

checkURLForColorChange();
