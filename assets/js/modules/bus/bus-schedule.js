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

		$('#pdfMe').click(function () {
      var doc = new jsPDF();
      doc.setFont("times");
      doc.fromHTML($('.scheduleToPDF').html(), 15, 15);
      doc.save('bus_schedule.pdf');
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
    var errorContainer = $('#availErrorContainer');
    var allTableRecords = table.find('tr');
    var recordData = [];
    var recordDataEntry = {};
    var json;
    var time = "";
    
    $(allTableRecords).each(function(i, v) {
      recordDataEntry.isDriver = '0';
      recordDataEntry.isBackup = '0';
      recordDataEntry.day = $('#schedule-header-date').text();
      errorContainer.empty();

      $(this).children('td').each(function(ii, vv) {
        recordDataEntry.id = $('#bus-name').val();
        if(this.classList.contains('tableDriverName') && ii == 0) {
          recordDataEntry.driver = $(this).text();
        }
        if(this.classList.contains('tableDriverTime') && ii == 1) {
          time = $(this).text();
          recordDataEntry.time = $(this).text();
        }
        if(this.classList.contains('roleSelect') && ii == 2) {
          var selectedRole = $(this).children(':checked').val();
          if(time === "AM") {
            if(selectedRole === "driver") {
              hasAMDriver = true;
              recordDataEntry.isDriver = '1';
            }
            if(selectedRole === "backup") {
              hasAMBackup = true;
              recordDataEntry.isBackup = '1';
            }
          }
          if(time === "PM") {
            if(selectedRole === "driver") {
              hasPMDriver = true;
              recordDataEntry.isDriver = '1';
            }
            if(selectedRole === "backup") {
              hasPMBackup = true;
              recordDataEntry.isBackup = '1';
            }
          }
        }
        if(ii == 2) {
          recordData.push(recordDataEntry);
          recordDataEntry = {};
        }
      }); 
    })
  
    json = JSON.stringify(recordData, null, 2);

    //parse json here to check for errors?
    var pass = bus_schedule.errorCheck(json);

    if(pass) {
      ajax.submitBusDriverSchedule('handleBusDriverSchedule', json);
    }
  },
  errorCheck: function(json) {
    var errorContainer = $('#availErrorContainer');
    errorContainer.empty();

    var hasAMDriver = false;
    var hasAMDriverMsg = '';

    var hasAMBackup = false;
    var hasAMBackupMsg = '';

    var hasPMDriver = false;
    var hasPMDriverMsg = '';

    var hasPMBackup = false;
    var hasPMBackupMsg = '';

    var jsonItems = JSON.parse(json).length;

    var pass = true;

    $.each($.parseJSON(json), function (i, driver) {
      if(driver.time == "AM") {
        if(driver.isDriver == 1) {
          if(hasAMDriver == false) {
            hasAMDriver = true;
          } else {
            pass = false;
            errorContainer.append('<h3 class="noAvailError">A driver is already exists for AM</h3>');
          } // driver exists check
        }
        if(driver.isBackup == 1) {
          if(hasAMBackup == false) {
            hasAMBackup = true;
          } else {
            pass = false;
            errorContainer.append('<h3 class="noAvailError">A backup is already exists for AM</h3>');
          }// backup exists check
        }
      } // end AM
      if(driver.time == "PM"){
        if(driver.isDriver == 1) {
          if(hasPMDriver == false) {
            hasPMDriver = true;
          } else {
            pass = false;
            errorContainer.append('<h3 class="noAvailError">A driver is already exists for PM</h3>');
          } // driver exists check
        }
        if(driver.isBackup == 1) {
          if(hasPMBackup == false) {
            hasPMBackup = true;
          } else {
            pass = false;
            errorContainer.append('<h3 class="noAvailError">A backup is already exists for PM</h3>');
          }// backup exists check
        }
      } // end PM
      if(parseInt(i+1) == jsonItems) {
        //need to make sure we've reached the end of the json before showing error for required stuff
        if(hasAMDriver == false) {
          pass = false;
          errorContainer.append('<h3 class="noAvailError">A driver is required for AM</h3>');
        }
        if(hasPMDriver == false) {
          pass = false;
          errorContainer.append('<h3 class="noAvailError">A driver is required for PM</h3>');
        }
      }
    });

    return pass;
  }
    
}
