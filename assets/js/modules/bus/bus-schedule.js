var bus_schedule = {
  /*
  * Method: init()
  * Description: initializes the bus namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: Called when bus is initalized
  */
  bindEvents: function() {
    $('table#schedule-list').on('click', 'a#clearRoles', function(e) {
      e.preventDefault();
      var selects = $(this).siblings('input');
      bus_schedule.clearRoles(selects);
    });
  },

  /*
  * Function to unselect the selected radio buttons for bus driver roles when making a schedule
  */
  clearRoles: function(selects) {
    $.each(selects, function(i, item) {
      $(item).prop('checked', false);
    });
  }
    
}
