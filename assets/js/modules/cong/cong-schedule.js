var cong_schedule = {
  /*
  * Method: init()
  * Description: initializes the congregation schedule namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
  
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: Called when congregation schedule is initialized
  */
  bindEvents: function() {
    $(function() {
      $("table.sortCongregations").sortable({
        items: "td.sort-cong-name"
      }).disableSelection();
    });
  }

}