var cong_blackouts = {
  /*
  * Method: init()
  * Description: initializes the blackouts namespace
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
    this.populateDrivers();

    $('.add-to-list').on('click', function(e) {
      var error = false;
      
      e.preventDefault();
      
      $("#error-container").empty();
      
      // make sure fields aren't empty
      if($('#cong-name').val() == "") {
        error = true;
        $('#error-container').append("<p>A Congregation is required.</p>");
      }
      
      if($('#cong-date').val() == "") {
        error = true;
        $('#error-container').append("<p>Date(s) is/are required.</p>");
      }

      if(!error){
        cong_blackouts.populateTable();
      }
    });

  }, 

  /*
  * Method: populateTable()
  * Description: Function to grab data from the input fields, if present, then present in a tabular format
  * Usage: Called from the click event of the Add To List button on the Driver Availability page
  */
  populateTable: function() {
    var html;
    var congName = $('#cong-name').find(":selected").text();
    var congDate = $('#cong-date').val();
    var table = $('table#list tbody');
    var date = $('#blackout-calendar').datepicker('getDate');
    var year = date.getFullYear();
    var month = date.getMonth();
    var dayOfWeek = date.getUTCDay();
    //new Date(year, month, day, hours, minutes, seconds, milliseconds);
    var startDate = new Date(year, month, date.getDate() - dayOfWeek, 0, 0, 0, 0);
    var endDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() + 7, 0, 0, 0, 0);
    var tableStartDate = cong_blackouts.getProperDateFormat(startDate);
    var tableEndDate = cong_blackouts.getProperDateFormat(endDate);

    //what we have now
      //selected date
      //start date
      //end date
    //what we need
      //to check if a selected date already exists as a blackout startDate-endDate

    var exists = cong_blackouts.checkExists(congDate);
    
    if(exists == false) {
        html =  '<tr>';
        html +=   '<td scope="row" class="tableCongName">' + congName +'</td>';
        html +=   '<td class="tableCongDate">' + tableStartDate + '</td>';
        html +=   '<td class="tableCongDate">' + tableEndDate + '<a id="delete-date"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
    }
  },

  getProperDateFormat: function(date) {
    var stringDate = date.toISOString().substring(0, 10);
    return stringDate;
  },

  /*
  * Method: checkExists()
  * @param: date - selected date from the calendar
  * Description: utility to check if a date already exists in that week
  * Returns: true or false
  */
  checkExists: function(_date) {
    var errorContainer = $('#error-container');
    var table = $('table#list tbody');
    var tableRows = $('table#list tbody > tr');
    var exists = false;

    errorContainer.empty();    

    if(tableRows.length > 0) {
      var rowStartDate;
      var rowEndDate;
      var rowDates;
      $.each(tableRows, function(j, rowDate) {
        rowDates = $(rowDate).find('td.tableCongDate');
        $.each(rowDates, function(k, date) {
          if(k == 0) {
            rowStartDate = $(date).text();
          } 
          if(k == 1) {
            rowEndDate = $(date).text();

            if(_date >= rowStartDate && _date <= rowEndDate){
              errorContainer.append('<p>Blackout Already Exists Between ' + rowStartDate + ' and ' + rowEndDate + '</p>');
              exists = true;
            } 
          }
        });
      });
    } else {
      exists = false;
    }
    return exists;

  },


  /* 
  * Method: populateDrivers()
  * Description: Function to make an ajax call to fetch cong data
  * Usage: Called when bus is initalized
  */
  populateDrivers: function() {
    ajax.getCongregations('returnCongregations');
  },
    
}
