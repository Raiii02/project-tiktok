function changeSVGColor(svgElement, color) {
  svgElement.setAttribute("fill", color);
}

function checkURLForColorChange() {
  var currentURL = window.location.href;

  var foryouIcon = document.querySelector(".foryou svg");
  var foryouText = document.querySelector(".foryou span.namehiden");

  var jelajahiIcon = document.querySelector(".live svg");
  var jelajahiText = document.querySelector(".live span.namehiden");

  var subcriptionsIcon = document.querySelector(".subcriptions svg");
  var subcriptionsText = document.querySelector(".subcriptions span.namehiden");

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

  if (currentURL === "http://localhost/project-tiktok/subscriber.php") {
    changeSVGColor(subcriptionsIcon, "rgba(254, 44, 85, 1)");
    subcriptionsText.style.color = "rgba(254, 44, 85, 1.0)";
  } else {
    changeSVGColor(subcriptionsIcon, "rgba(22, 24, 35, 1)");
    subcriptionsText.style.color = "rgba(22, 24, 35, 1.0)";
  }
}

checkURLForColorChange();
