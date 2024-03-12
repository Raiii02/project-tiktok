function openTab(tabId) {
  // Menghapus kelas 'active' dari semua tab dan konten tab
  var tabs = document.querySelectorAll('.tab');
  tabs.forEach(function (tab) {
    tab.classList.remove('active');
  });

  var tabContents = document.querySelectorAll('.tab-content');
  tabContents.forEach(function (tabContent) {
    tabContent.classList.remove('active');
  });

  // Menambahkan kelas 'active' pada tab yang dipilih dan konten tab yang sesuai
  var selectedTab = document.getElementById(tabId);
  selectedTab.classList.add('active');
  var selectedTabContent = document.getElementById('panel-' + tabId.slice(4));
  selectedTabContent.classList.add('active');
}


document.addEventListener("DOMContentLoaded", function () {
  // Fungsi untuk mengarahkan pengguna ke halaman baru saat video diklik
  document.getElementById("myVideo1").addEventListener("click", function () {
    window.location.href = "index.html"; // Ganti "index.html" dengan URL halaman baru yang ingin Anda tuju
  });

  // Fungsi untuk mengelola video TikTok
  const videos = document.querySelectorAll(".video-tiktok video");
  videos.forEach(video => {
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
  const videoDescriptions = document.querySelectorAll('.video-description p'); // Mengubah selector
  const maxLength = 25; // Jumlah maksimum karakter yang diinginkan
  videoDescriptions.forEach(description => {
    if (description.textContent.length > maxLength) {
      const trimmedDescription = description.textContent.substr(0, maxLength) + "...";
      description.textContent = trimmedDescription;
    }
  });

  // Membuka tab pertama secara otomatis saat halaman dimuat
  document.getElementById('tab-1').click();
});
