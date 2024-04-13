const tabsBox = document.querySelector(".tabs-box");
const allTabs = tabsBox.querySelectorAll(".tab");
const arrowIcons = document.querySelectorAll(".icon i");

let isDragging = false;

const handleIcons = (scrollVal) => {
  let maxScrollableWidth = tabsBox.scrollWidth - tabsBox.clientWidth;
  arrowIcons[0].parentElement.style.display = scrollVal <= 0 ? "none" : "flex";
  arrowIcons[1].parentElement.style.display =
    maxScrollableWidth - scrollVal <= 1 ? "none" : "flex";
};

arrowIcons.forEach((icon) => {
  icon.addEventListener("click", () => {
    let scrollWidth = (tabsBox.scrollLeft += icon.id === "left" ? -340 : 340);
    handleIcons(scrollWidth);
  });
});

allTabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    tabsBox.querySelector(".active").classList.remove("active");
    tab.classList.add("active");
  });
});

const dragging = (e) => {
  if (!isDragging) return;
  tabsBox.classList.add("dragging");
  tabsBox.scrollLeft -= e.movementX;
  handleIcons(tabsBox.scrollLeft);
};

const dragStop = () => {
  isDragging = false;
  tabsBox.classList.remove("dragging");
};

tabsBox.addEventListener("mousedown", () => (isDragging = true));
tabsBox.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);

const videoDescriptions = document.querySelectorAll(".jelajahi-description p");
const maxLength = 34;

videoDescriptions.forEach((description) => {
  if (description.textContent.length > maxLength) {
    const trimmedDescription =
      description.textContent.substr(0, maxLength) + "...";
    description.textContent = trimmedDescription;
  }
});

// Auto play the first video
const firstVideo = document.querySelector(
  ".grid-container .jalajah-card video"
);
firstVideo.muted = true; // Mute the first video
firstVideo.play();

// Autoplay next video when current video ends
document
  .querySelectorAll(".jalajah-card video")
  .forEach((video, index, videos) => {
    video.muted = true; // Mute all videos
    video.addEventListener("ended", () => {
      const nextIndex = (index + 1) % videos.length;
      videos[nextIndex].play();
    });
  });

// Pause other videos on hover and play hovered video
document
  .querySelectorAll(".jalajah-card video")
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
      video.play(); // Play the hovered video
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

document.addEventListener("keydown", function (event) {
  const key = event.key;
  const videos = document.querySelectorAll("video");

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
    console.log("masuk");
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


