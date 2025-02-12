
(function () {

  <?php if(security_is_logged_in()): ?>
    
  let user = <?=json_encode($_SESSION['user'])?>;
  let city = <?=json_encode($_SESSION['user'])?>;

  <?php else: ?>

  let user = "";
  let city = "";
    
  <?php endif; ?>

  let body = document.getElementsByTagName("body")[0];
  let head = document.getElementsByTagName("head")[0];

  /*
  let w3 = false;
  let w3Check = document.getElementsByTagName("link");
  for (let i = 0; i < w3Check.length; i++) {
    if (w3Check[i].href.includes("w3.css")) {
      w3 = true;
    }
  }

  if (!w3) {
    let head = document.getElementsByTagName("head")[0];
    let link = document.createElement("link");
    link.href = "https://www.w3schools.com/w3css/4/w3.css";
    link.rel = "stylesheet";
    head.append(link);
  }
  */

  let fa = false;
  let faCheck = document.getElementsByTagName("script");
  for (let i = 0; i < faCheck.length; i++) {
    if (faCheck[i].src.includes("fontawesome.css")) {
      fa = true;
    }
  }

  if (!fa) {
    let scriptFa = document.createElement("script");
    scriptFa.src = "https://kit.fontawesome.com/a74f41de6e.js";
    scriptFa.crossorigin = "anonymous";
    body.append(scriptFa);

    let linkExceptions = document.createElement("link");
    linkExceptions.href =
      "https://cdn.brickmmo.com/exceptions@1.0.0/fontawesome.css";
    linkExceptions.rel = "stylesheet";
    head.append(linkExceptions);
  }

  let div = document.createElement("div");
  div.style.backgroundColor = "#fff";
  div.style.borderBottom = "1px solid #ccc";
  div.style.position = "sticky";
  div.style.top = "0";
  div.style.padding = "8px 16px";

  let divMain = document.createElement("div");
  divMain.style.display = "table";
  divMain.style.width = "100%";
  div.append(divMain);

  let divLeft = document.createElement("div");
  divLeft.style.display = "table-cell";
  divLeft.style.fontSize = "15px";
  divLeft.style.verticalAlign = "middle";
  divMain.append(divLeft);

  let aAccount = document.createElement("a");
  aAccount.href = "https://account.brickmmo.com/";
  divLeft.append(aAccount);

  let logo = document.createElement("img");
  logo.src =
    "https://cdn.brickmmo.com/images@1.0.0/brickmmo-logo-coloured-horizontal.png";
  logo.style.height = "35px";
  logo.style.width = "112px";
  logo.verticalAlign = "middle";
  aAccount.append(logo);

  let divRight = document.createElement("div");
  divRight.style.display = "table-cell";
  divRight.style.textAlign = "right";
  divRight.style.fontSize = "15px";
  divRight.style.verticalAlign = "middle";
  divMain.append(divRight);

  let aApps = document.createElement("a");
  aApps.href = "https://account.brickmmo.com/apps";
  divRight.append(aApps);

  let i = document.createElement("i");
  i.style.color = "#666";
  i.style.textDecoration = "none";
  i.classList.add("fa-solid");
  i.classList.add("fa-grip-vertical");
  aApps.append(i);

  console.log(user);
  console.log(user.avatar);

  if(user && user.avatar)
  {

    let aUser = document.createElement("a");
    aUser.href = "https://account.brickmmo.com/account/dashboard";
    divRight.prepend(aUser);

    let avatar = document.createElement("img");
    avatar.src = user.avatar;
    avatar.style.height = "35px";
    avatar.style.width = "35px";
    avatar.style.verticalAlign = "middle";
    avatar.style.borderRadius = "50%";
    avatar.style.borderStyle = "none";
    avatar.style.marginRight = "10px";
    aUser.append(avatar);

  }

  body.prepend(div);
})();
