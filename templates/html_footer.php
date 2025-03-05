
    
<div id="confirm" class="w3-modal" style="z-index: 200; opacity: 0; border: display: none">
  <div class="w3-modal-content w3-card-4">
    <div class="w3-container">
      <p id="confirm-content">Please confirm...</p>
    </div>
    <footer class="w3-container w3-border-top w3-right-align w3-padding">
      <a class="w3-button w3-white w3-border" href="" id="confirm-url">
      <i class="fa-solid fa-chevron-right fa-padding-right"></i>
        Continue
      </a>
      <button class="w3-button w3-white w3-border" onclick="closeModal('confirm');">
        Cancel
      </button>
    </footer>
  </div>
</div>

<script>

  function confirmModal(text, url)
  {

    let confirmContent = document.getElementById('confirm-content');
    let confirmUrl = document.getElementById('confirm-url');

    confirmContent.innerHTML = text;
    confirmUrl.href = url;

    openModal('confirm');
    return false;

  }

</script>

<script src="https://kit.fontawesome.com/ce455df547.js" crossorigin="anonymous"></script>

<!-- Script JavaScript File -->
<script src="/script.js"></script>

  </body>
</html>
