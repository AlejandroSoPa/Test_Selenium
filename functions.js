
  function showNotification(type, message) {
    var notificationContainer = $(`
      <div class="notification-container"></div>
    `);

    var notification = $(`
      <div class="notification ${type}">${message}</div>
    `);

    var closeIcon = $(`
      <span class="close-icon">x</span>
    `);
    closeIcon.on('click', function () {
      closeNotification(notificationContainer);
    });

    notification.append(closeIcon);
    notificationContainer.append(notification);
    $('#notificationContainer').append(notificationContainer);
    notification.css('display', 'block');
    notification.hide().slideDown();
  }

  function closeNotification(notificationContainer) {
    notificationContainer.css('display', 'none');
    notificationContainer.remove();
  }
  //showNotification('warning', 'Funciono correctamentedasdasdasdasdasdasdsadddanfidsnfonasoifdniofdifasfndaslfdsafasfndasfiaunfl');
  //showNotification('info', 'Mensaje de error');



