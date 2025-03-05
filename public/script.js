function openModal(id) {
  let modal = document.getElementById(id);

  modal.style.display = "block";

  setTimeout(function () {
    modal.style.transition = "0.5s";
    modal.style.opacity = "1";
  }, 0);
}

function closeModal(id) {
  let modal = document.getElementById(id);

  modal.style.transition = "0.5s";
  modal.style.opacity = "0";

  setTimeout(function () {
    modal.style.display = "none";
  }, 500);
}

(function(){

  const hideButton = document.getElementsByClassName('hide_button');
  const showButton = document.getElementsByClassName('show_button');

  for(let i = 0; i < hideButton.length; i ++)
  {
    hideButton[i].addEventListener("click", function(event){

      this.parentNode.querySelectorAll(".hide_content")[0].style.display = "inline";
      this.parentNode.querySelectorAll(".hide_button")[0].style.display = "none";
      this.parentNode.querySelectorAll(".show_content")[0].style.display = "none";
      this.parentNode.querySelectorAll(".show_button")[0].style.display = "inline";

    });
    showButton[i].addEventListener("click", function(event){

      this.parentNode.querySelectorAll(".hide_content")[0].style.display = "none";
      this.parentNode.querySelectorAll(".hide_button")[0].style.display = "inline";
      this.parentNode.querySelectorAll(".show_content")[0].style.display = "inline";
      this.parentNode.querySelectorAll(".show_button")[0].style.display = "none";

    });

    const copyButton = document.getElementsByClassName('copy_button');
    copyButton[i].addEventListener("click", function(event){

      var range = document.createRange();
      range.selectNode(this);
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
      document.execCommand("copy");
      // window.getSelection().removeAllRanges();

      confirmModal('Text has been copied to the clipboard', false);

    });
  }

})();

