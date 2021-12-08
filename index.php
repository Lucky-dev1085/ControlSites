<?php
session_start();

if ($_SESSION["loggedIn"] == true) {
  header("Location: dashboard.php");
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
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <div id="dark-nav-bar">
    <div class="container natural-middle">
      <p class="natural-left" id="nav-bar-title">Control Panel</p>
      <p class="natural-right" id="log-out">log out</p>
    </div>
  </div>
  <div class="surface">
    <br>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="table">
            <div class="row">
              <div class="col-12 login">
                <form action="dashboard.php" method="POST">
                  <h1 class="form-title">Login</h1>
                  <div class="form-group">
                    <label class="form-caption">Password</label>
                    <input class="form-control admin-form" name="password" placeholder="Password">
                    <input type="submit" value="Log in" class="admin-submit">
                  </div>
                </form>
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
  <script src="js/growl-notification/growl-notification.min.js"></script>
  <script src="js/notifications.js"></script>
  <script src="js/main.js"></script>
</body>

</html>