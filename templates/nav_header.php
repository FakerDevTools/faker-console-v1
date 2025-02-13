<!-- TOP NAVIGATION -->

<script>

    window.onload = (event) => {
        let sidebar = document.getElementById("sidebar");
        let overlay = document.getElementById("sidebarOverlay");

        let width = sidebar.getBoundingClientRect().width;

        sidebar.style.left = "-" + width + "px";
        overlay.style.display = "none";
        overlay.style.opacity = "0";
    };

    function w3_sidebar_toggle(event) {
        let sidebar = document.getElementById("sidebar");
        let overlay = document.getElementById("sidebarOverlay");
        let width = sidebar.getBoundingClientRect().width;

        if (sidebar.style.left == "0px") {
            sidebar.style.transition = "0.5s";
            sidebar.style.left = "-" + width + "px";

            overlay.style.transition = "0.5s";
            overlay.style.opacity = "0";

            setTimeout(function () {
            overlay.style.display = "none";
            w3_sidebar_close_all();
            }, 500);
        } else {
            sidebar.style.transition = "0.5s";
            sidebar.style.left = "0px";

            overlay.style.display = "block";

            setTimeout(function () {
            overlay.style.transition = "0.5s";
            overlay.style.opacity = "1";
            }, 0);

            close_avatar_options();
        }

        if(event)
        {
            event.preventDefault();
            event.stopPropagation();
        }
    }
    
</script>

<nav
    class="w3-bar w3-border-bottom w3-padding w3-white w3-top"
    style="position: sticky; z-index: 110; height: 58px; overflow: visible"
>
    <div style="height: 100vh; position: absolute; top: -100vh; left: 0; width: 100vw; background: white"></div>

    <div class="w3-row">

        <div class="w3-col s6">

            <button class="w3-button" onclick="w3_sidebar_toggle(event)">
                <i class="fa-solid fa-bars"></i>
            </button>
            <a href="<?=ENV_CONSOLE_DOMAIN?>/application/dashboard" onclick="prevent(event)"
            ><img
                src="https://cdn.brickmmo.com/images@1.0.0/brickmmo-logo-coloured-horizontal.png"
                style="height: 35px"
            /></a>

            <?php if($_application): ?>
                <button
                    class="w3-border w3-border-gray w3-button w3-margin-left"
                    onclick="open_modal('application')"
                >
                    <i class="fa-solid fa-application fa-padding-right"></i>
                    <?=$_application['name']?>
                    <i class="fa-solid fa-caret-down"></i>
                </button>
            <?php else: ?>
                <button
                    onclick="location.href='<?=ENV_ACCOUNT_DOMAIN?>/application/create';"
                    class="w3-border w3-border-gray w3-button w3-margin-left"
                >
                   <i class="fa-solid fa-plus fa-padding-right"></i>
                    Create Application
                </button>
            <?php endif; ?>

        </div>

        <div class="w3-col s6 w3-right-align">
            
            <img
                src="<?=user_avatar($_user['id']);?>"
                style="height: 35px"
                class="w3-circle bm-pointer"
                _onclick="return toggleAvatarOptions(event)"
                onclick="open_modal('avatar-options');"
            />
      
            <button class="w3-button" onclick="window.location='https://applications.brickmmo.com';">
                <i class="fa-solid fa-grip-vertical"></i>
            </button>

        </div>

    </div>

</nav>

<div
  id="avatar-options"
  class="w3-modal"
  style="z-index: 200; opacity: 0; display: none"
>

    <div class="w3-card-4 w3-border" style="max-width: 300px; position: fixed; top: 68px; right: 10px; z-index: 120" id="">
        
        <img src="<?=user_avatar($_user['id']);?>" alt="Alps" style="max-width: 100%">

        <div class="w3-container w3-white">

            <p>
                You are logged in as 
                <a href="<?=ENV_ACCOUNT_DOMAIN?>/account/dashboard"><?=user_name($_user['id'])?></a>
            </p>
            <?php if($_user['github_username']): ?>
                <p>
                    <a href="https://github.com/<?=$_user['github_username']?>">
                        <i class="fa-brands fa-github fa-padding-right"></i>
                        <?=$_user['github_username']?>
                    </a>
                </p>
            <?php endif; ?>

        </div>

        <footer class="w3-container w3-center w3-light-grey w3-padding w3-border-top">

            <a class="w3-button w3-border w3-white" href="<?=ENV_ACCOUNT_DOMAIN?>/account/dashboard">
                <i class="fa-solid fa-user fa-padding-right "></i>
                My Account
            </a>
            <a class="w3-button w3-border w3-white" href="<?=ENV_ACCOUNT_DOMAIN?>/action/logout">
                <i class="fa-solid fa-lock-open fa-padding-right "></i>
                Logout
            </a>
            <a class="w3-button w3-white w3-border w3-margin-top" onclick="close_modal('avatar-options');">
                Close
            </a>
            
        </footer>

    </div>

</div>

<script>

    function toggleAvatarOptions(event)
    {
        
        var avatarOptions = document.getElementById("avatar-options");
        if (avatarOptions.style.display == "block") 
        {
            close_avatar_options();
        } 
        else 
        { 
            avatarOptions.style.display = "block";
            close_sidebar();
        }

        event.preventDefault();
        event.stopPropagation();

    }

    document.addEventListener('click', function(e){

        if(e.target.className == "w3-overlay" || e.target.className == "w3-modal")
        {
            close_avatar_options();
            close_sidebar();
            close_all_modals();
        }

    });

    function close_all_modals()
    {

        let modals = document.getElementsByClassName('w3-modal');
        for(var i = 0; i < modals.length; i++) 
        {
            close_modal(modals[i].id);
        }

    }

    function close_sidebar()
    {

        let sidebar = document.getElementById("sidebar");
        if (sidebar.style.left == "0px") {
            w3_sidebar_toggle(false);
        }

    }

    function close_avatar_options()
    {

        var avatarOptions = document.getElementById("avatar-options");
        if (avatarOptions.style.display == "block")
        {
            avatarOptions.style.display = "none";
        }
        
    }

</script>
