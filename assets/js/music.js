// Adds music
const music = document.getElementById("background-music");
const musicToggle = document.getElementById("music-toggle");
// this triggers the music to play or pause
musicToggle.addEventListener("click", () => {
  if (music.paused) {
    music.play();
    musicToggle.textContent = "Music On";
  } else {
    music.pause();
    musicToggle.textContent = "Music Off";
  }
});
