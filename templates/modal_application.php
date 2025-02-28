<?php if($_application): ?>

<?php

$query = 'SELECT applications.*
    FROM applications
    INNER JOIN application_user ON applications.id = application_user.application_id
    WHERE application_user.user_id = '.$_user['id'].'
    AND deleted_at IS NULL
    ORDER BY name';
$result = mysqli_query($connect, $query);

?>

<!-- CITY MODAL -->
<div
  id="application"
  class="w3-modal"
  style="z-index: 200; opacity: 0; border: display: none"
>
  <div class="w3-modal-content w3-card-4">
    <header class="w3-bar w3-border-bottom w3-padding w3-white">
      <div class="w3-row">
        <div class="w3-col s6">
          <p style="margin-block-end: 8px; margin-block-start: 8px">
            <i class="fa-solid fa-server fa-padding-right"></i> 
            Select a Application
          </p>
        </div>
        <div class="w3-col s6 w3-right-align"></div>
      </div>
    </header>
    <div class="w3-container">
      <table class="w3-table w3-bordered w3-striped w3-margin-bottom">
        <tr>
          <th class="bm-table-icon"></th>
          <th>Name</th>
          <th class="bm=table-icon"></th>
        </tr>

        <?php while($record = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <?php if($_application['id'] == $record['id']): ?>
                        <i class="fa-solid fa-check"></i>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/action/application/select/id/<?=$record['id']?>"><?=$record['name']?></a>
                </td>
                <td></td>
            </tr>
        <?php endwhile; ?>

      </table>
    </div>
    <footer class="w3-container w3-border-top w3-right-align w3-padding">
      <a class="w3-button w3-white w3-border" href="<?=ENV_CONSOLE_DOMAIN?>/application/create">
        <i class="fa-solid fa-plus fa-padding-right"></i>
        Create Application
      </a>
      <button
        class="w3-button w3-white w3-border"
        onclick="close_modal('application');"
      >
        Close
      </button>
    </footer>
  </div>
</div>

<?php endif; ?>