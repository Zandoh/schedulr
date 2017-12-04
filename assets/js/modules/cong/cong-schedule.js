var cong_schedule = {
  /*
  * Method: init()
  * Description: initializes the congregation schedule namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    this.makeDraggable();
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: Called when congregation schedule is initialized
  */
  bindEvents: function() {
    $('#updateCongregations').on('click', function(e){
      e.preventDefault();
      cong_schedule.submitCongregations();
    });

  },
  /*
  * Function called when a user creates a new rotation
  */
  addRotation: function() {
    ajax.generateNewRotation('generateCongregationSchedule');
  },

  /*
  * Function to make the congregation names draggable and droppable for each week
  */
  makeDraggable: function() {
      $(".sort-cong-name").draggable({
        helper: "clone",
        start: function(e) {
          placeholder = e.target;
          $(placeholder).addClass("opacity");
        },
        stop: function(e){
          $(placeholder).removeClass("opacity");
          placeholder = null;
        }  
        
    });
    $(".sort-cong-name").droppable({
        drop: function (e, ui) {
            $(placeholder).removeClass("opacity");
            placeholder = null;
            $(ui.draggable).clone().replaceAll(this);
            $(this).replaceAll(ui.draggable);
            cong_schedule.makeDraggable();
        },
    });
  },

  /*
  * Function to transform schedule into json
  */
  submitCongregations: function() {
    var table = $('table.sortCongregations tbody');
    var allTableRecords = table.find('tr');
    var recordData = [];
    var recordDataEntry = {};
    var json;
    
    $(allTableRecords).each(function(i, v) {
      $(this).children('td').each(function(ii, vv) {
        recordDataEntry.rotation = $(".congregation-schedule-id").attr('id');
        this.classList.contains('tableCongDate') && ii == 0 ? recordDataEntry.start_date = $(this).text() : '';
        this.classList.contains('tableCongDate') && ii == 1 ? recordDataEntry.end_date = $(this).text() : '';
        this.classList.contains('sort-cong-name') && ii == 2 ? recordDataEntry.id = $(this).attr('id') : '';
        if(ii == 2){
          recordData.push(recordDataEntry);
          recordDataEntry = {};
        }
      }); 
    })
  
    json = JSON.stringify(recordData, null, 2);
    console.log(json);
    ajax.submitCongregationSchedule('editSchedule', json);
  }

}