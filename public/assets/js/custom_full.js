var elem = document.documentElement;

function openFullscreen() {
  if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
    requestFullscreen();
    toggleFullscreenIcons(true);
  } else {
    exitFullscreen();
    toggleFullscreenIcons(false);
  }
}

function requestFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.webkitRequestFullscreen) {
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) {
    elem.msRequestFullscreen();
  }
}

function exitFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
}

function toggleFullscreenIcons(isFullscreen) {
  const openIcon = document.querySelector('.full-screen-open');
  const closeIcon = document.querySelector('.full-screen-close');
  if (isFullscreen) {
    openIcon.classList.add('d-none');
    closeIcon.classList.remove('d-none');
  } else {
    openIcon.classList.remove('d-none');
    closeIcon.classList.add('d-none');
  }
}
