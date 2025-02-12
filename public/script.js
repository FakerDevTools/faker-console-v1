function open_modal(id) {
  let modal = document.getElementById(id);

  modal.style.display = "block";

  setTimeout(function () {
    modal.style.transition = "0.5s";
    modal.style.opacity = "1";
  }, 0);
}

function close_modal(id) {
  let modal = document.getElementById(id);

  modal.style.transition = "0.5s";
  modal.style.opacity = "0";

  setTimeout(function () {
    modal.style.display = "none";
  }, 500);
}
