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

    $('#busScheduleSubmit').on('click', function(e){
      e.preventDefault();
      bus_schedule.submitSchedule();
    });

  },

  /*
  * Function to unselect the selected radio buttons for bus driver roles when making a schedule
  */
  clearRoles: function(selects) {
    $.each(selects, function(i, item) {
      $(item).prop('checked', false);
    });
  },

  submitSchedule: function(){
    var table = $('table#schedule-list tbody');
    var allTableRecords = table.find('tr');
    var recordData = [];
    var recordDataEntry = {};
    var json;
    var time = "";
    var hasAM, hasPM = false;
    
    //make sure AM and PM have driver


    $(allTableRecords).each(function(i, v) {
      $(this).children('td').each(function(ii, vv) {
        recordDataEntry.id = $('#bus-name').val();
        if(this.classList.contains('tableDriverName') && ii == 0) {
          recordDataEntry.name = $(this).text();
        }
        if(this.classList.contains('tableDriverTime') && ii == 1) {
          time = $(this).text();
          recordDataEntry.date = $(this).text();
        }
        if(this.classList.contains('roleSelect') && ii == 2) {
          if(time === "AM") {
            hasAM = true;
          }
          if(time === "PM") {
            hasPM = true;
          }
          recordDataEntry.time ='';
        }
        
        if(ii == 2){
          recordData.push(recordDataEntry);
          recordDataEntry = {};
        }
      }); 
    })
  
    json = JSON.stringify(recordData, null, 2);

    //ajax.submitBusDriverAvailability('processDriverAvailability', json);
  }
    
}
