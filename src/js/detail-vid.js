function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcon");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("TabLink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";

  // Hide comment input form when switching to VidKreator tab
  if (cityName === "VidKreator") {
    document.querySelector(".BottomComment").style.display = "none";
  } else {
    document.querySelector(".BottomComment").style.display = "block";
  }
}

window.onload = function () {
  openCity(event, "Komentar");
  const komentarTab = document.querySelector(".TabLink:first-child");
  komentarTab.classList.add("active");

  const videos = document.querySelectorAll(".content-vid video");

  videos.forEach(function (video) {
    video.addEventListener("click", function (event) {
      event.preventDefault();
    });

    video.addEventListener("dblclick", function (event) {
      event.preventDefault();
    });
  });
};

document.addEventListener("DOMContentLoaded", function () {
  const videos = document.querySelectorAll(".content-vid video");

  // Function to check if an element is in the viewport
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <=
        (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  // Loop through each video and start playing if it's in the viewport
  videos.forEach(function (video) {
    if (isInViewport(video)) {
      video.muted = true;
      video.play();
    }
  });

  // Add scroll event listener to start playing videos when they enter the viewport
  window.addEventListener("scroll", function () {
    videos.forEach(function (video) {
      if (isInViewport(video)) {
        video.muted = true;
        video.play();
      } else {
        video.pause();
      }
    });
  });
});

document.addEventListener("keydown", function (event) {
  const key = event.key;
  const videos = document.querySelectorAll(".content-vid video");

  // Cek apakah elemen fokus saat ini bukanlah input teks
  const activeElement = document.activeElement.tagName.toLowerCase();
  if (activeElement !== "input" && activeElement !== "textarea") {
    switch (key) {
      case " ":
        event.preventDefault(); // Menghentikan perilaku default dari spasi (scrolling)
        for (var i = 0; i < videos.length; i++) {
          var video = videos[i];
          if (isInViewport(video)) {
            if (video.paused) {
              playVideo(video); // Memanggil fungsi playVideo
            } else {
              pauseVideo(video); // Memanggil fungsi pauseVideo
            }
            break;
          }
        }
        break;
      case "m":
      case "M":
        videos.forEach((video) => {
          video.muted = !video.muted;
        });
        break;
    }
  }
});

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

function isInViewport(element) {
  var rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

document.addEventListener("DOMContentLoaded", function () {
  const kreatorsVideos = document.querySelectorAll(".VideoKreator video");

  // Function to play video on mouse enter and pause on mouse leave
  kreatorsVideos.forEach(function (video) {
    video.addEventListener("mouseenter", function () {
      video.muted = true; // Set video to muted
      video.play();
    });
    video.addEventListener("mouseleave", function () {
      video.pause();
      video.currentTime = 0; // Rewind the video to the beginning
    });
  });
});

const timeComments = document.querySelectorAll(".subcoment span");
const maxLengthComments = 7;
timeComments.forEach((description) => {
  if (description.textContent.length > maxLengthComments) {
    const trimmedDescription =
      description.textContent.substr(0, maxLengthComments) + "...";
    description.textContent = trimmedDescription;
  }
});

const videoDescriptions = document.querySelectorAll(".Caption span");
const maxLength = 120;
videoDescriptions.forEach((description) => {
  if (description.textContent.length > maxLength) {
    const trimmedDescription =
      description.textContent.substr(0, maxLength) + " ...";
    description.textContent = trimmedDescription;
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var inputField = document.getElementById("DivInput");
  var postButton = document.getElementById("postButton");

  function handleInput() {
    var inputText = inputField.value.trim();
    if (inputText === "" || inputText === inputField.placeholder) {
      postButton.disabled = true;
      postButton.classList.add("disabled");
    } else {
      postButton.disabled = false;
      postButton.classList.remove("disabled");
    }
  }

  handleInput();
  inputField.addEventListener("input", handleInput);
});
