const tabsBox = document.querySelector(".tabs-box"),
    allTabs = tabsBox.querySelectorAll(".tab"),
    arrowIcons = document.querySelectorAll(".icon i");

let isDragging = false;

const handleIcons = (scrollVal) => {
    let maxScrollableWidth = tabsBox.scrollWidth - tabsBox.clientWidth;
    arrowIcons[0].parentElement.style.display = scrollVal <= 0 ? "none" : "flex";
    arrowIcons[1].parentElement.style.display = maxScrollableWidth - scrollVal <= 1 ? "none" : "flex";
}

arrowIcons.forEach(icon => {
    icon.addEventListener("click", () => {
        // if clicked icon is left, reduce 350 from tabsBox scrollLeft else add
        let scrollWidth = tabsBox.scrollLeft += icon.id === "left" ? -340 : 340;
        handleIcons(scrollWidth);
    });
});

allTabs.forEach(tab => {
    tab.addEventListener("click", () => {
        tabsBox.querySelector(".active").classList.remove("active");
        tab.classList.add("active");
    });
});

const dragging = (e) => {
    if (!isDragging) return;
    tabsBox.classList.add("dragging");
    tabsBox.scrollLeft -= e.movementX;
    handleIcons(tabsBox.scrollLeft)
}

const dragStop = () => {
    isDragging = false;
    tabsBox.classList.remove("dragging");
}

tabsBox.addEventListener("mousedown", () => isDragging = true);
tabsBox.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);


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
  function checkFile() {
    var fileInput = document.getElementById('videoFile');
    var uploadButton = document.getElementById('uploadButton');
    var loadingIcon = document.getElementById('loadingIcon');

    // Tampilkan animasi loading
    loadingIcon.style.display = 'block';

    // Simulasikan proses loading
    setTimeout(function() {
      if (fileInput.files.length > 0) {
        // Sembunyikan animasi loading dan tampilkan tombol unggah
        loadingIcon.style.display = 'none';
        uploadButton.style.display = 'block';
      }
    }, 1000); // Ganti nilai 2000 dengan waktu yang sesuai dengan proses loading nyata
  }

  function uploadVideo() {
    // Logika untuk mengunggah video
    console.log('Video diunggah!');
  }