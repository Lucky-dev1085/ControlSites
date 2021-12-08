var sound_enabled = true;

$(document).ready(function() {
  configure_notification_sound();
  delete_database_click()
  configure_tool_tips();
  animate_widget_icon_on_hover();
});

function configure_tool_tips() {
  tippy('#notification', {
    content: 'Toggle sound',
  });

  tippy('#delete-db', {
    content: 'Delete database',
  });
}

function configure_notification_sound() {
  $('#notification').click(function() {

    if ($(this).hasClass("fa-bell")) {
      $.ajax({
        type: 'GET',
        url: 'php_functions/sound_manager.php?disable_sound',
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == 'disabled') {
            $('#notification').removeClass("fa-bell").addClass("fa-bell-slash");
          }
        }
      })
      return;
    }

    if ($(this).hasClass("fa-bell-slash")) {
      $.ajax({
        type: 'GET',
        url: 'php_functions/sound_manager.php?enable_sound',
        success: function(data) {
          let parsed_data = JSON.parse(data);

          if (parsed_data.status == 'enabled') {
            $('#notification').removeClass("fa-bell-slash").addClass("fa-bell");
          }
        }
      })
      return;
    }
  });
}

function delete_database_click() {
  $('#delete-db').click(function() {
    delete_database();
  });
}

function delete_database() {
  $.ajax({
    url: '../database_setup/routes/delete_db.php',
    type: 'POST',
    success: function(_response) {
      display_success_notif("Successfully Deleted Database");
      setTimeout(function() {
        window.location.reload();
      }, 1500)
    },
    error: function(err) {
      console.log("Error while fetching database info: " + err);
    }
  });
}

function animate_widget_icon_on_hover() {
  $('.surface-widget').hover(function() {
    $("i", this).addClass("animate");
  }, function() {
    $("i", this).removeClass("animate");
  })
}

function poll_rows(currentRows) {
  $.ajax({
    type: 'GET',
    url: 'php_polling/get_rows.php',
    success: function(_response) {
      var response = JSON.parse(_response);
      var rowNumber = response["row_number"];

      if (parseInt(rowNumber) > currentRows) {
        window.location.reload();
      }
    }
  });
}
