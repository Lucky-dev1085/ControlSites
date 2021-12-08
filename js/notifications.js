function display_success_notif(message) {
  GrowlNotification.notify({
    title: 'Success',
    description: message,
    type: 'success',
    closeTimeout: 3000
  });
}
