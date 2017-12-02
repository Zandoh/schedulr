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
    this.populateCongregations();

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

    $('#cong-blackout-submit').on('click', function(e) {
      e.preventDefault();
      cong_blackouts.submitBlackouts();
    });

    /*
    * Method to populate table on change of the select list
    */
    $('#cong-name').on('change', function (e) {
      var optionSelected = $("option:selected", this);
      var valueSelected = this.value;
      
      if(valueSelected != '') {
        ajax.getBlackouts('returnBlackouts', valueSelected);
      }
      
    });

    /* 
    * Interpreted as a click event on the anchor tag with an ID of delete-blackout
    * This syntax is used since the anchor tags are dynamically generated
    */
    $('table#blackout-list').on('click', 'a#delete-blackout', function(e) {
      e.preventDefault();
      cong_blackouts.removeBlackoutRecord(this);
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
    var table = $('table#blackout-list tbody');
    var date = $('#blackout-calendar').datepicker('getDate');
    var year = date.getFullYear();
    var month = date.getMonth();
    var dayOfWeek = date.getUTCDay();
    //new Date(year, month, day, hours, minutes, seconds, milliseconds);
    var startDate = new Date(year, month, date.getDate() - dayOfWeek, 0, 0, 0, 0);
    var endDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() + 7, 0, 0, 0, 0);
    var tableStartDate = cong_blackouts.getProperDateFormat(startDate);
    var tableEndDate = cong_blackouts.getProperDateFormat(endDate);

    var exists = cong_blackouts.checkExists(congDate);
    
    if(exists == false) {
        html =  '<tr>';
        html +=   '<td scope="row" class="tableCongName">' + congName +'</td>';
        html +=   '<td class="tableCongDate">' + tableStartDate + '</td>';
        html +=   '<td class="tableCongDate">' + tableEndDate + '<a id="delete-blackout"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
    }

    $('#blackout-calendar').multiDatesPicker('removeIndexes',0);
  },

  /*
  * Method: removeBlackoutRecord
  * Description: Removes a record from the List of Blackouts
  * Usage: Called from the click event of the delete icon
  */
  removeBlackoutRecord: function(anchor) {
    $(anchor).parents().closest('tr').empty().remove();
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
    var table = $('table#blackout-list tbody');
    var tableRows = $('table#blackout-list tbody > tr');
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
  * Method: populateCongregations()
  * Description: Function to make an ajax call to fetch cong data
  * Usage: Called when bus is initalized
  */
  populateCongregations: function() {
    ajax.getCongregations('returnCongregations');
  },

  /*
  * Method: submitBlackouts()
  * Description: Function helper to convert form data into JSON to handle on the backend
  * Usage: Called from the click event of the Submit button on the Congregation Blackouts  page
  * Sample JSON:
  * [
  *   {
        "id": "1"
  *     "start_date": "YYYY-MM-DD",
  *     "end_date": "YYYY-MM-DD"
  *   }
  * ]
  */
  submitBlackouts: function() {
    var table = $('table#blackout-list tbody');
    var allTableRecords = table.find('tr');
    var recordData = [];
    var recordDataEntry = {};
    var json;
    
    $(allTableRecords).each(function(i, v) {
      $(this).children('td').each(function(ii, vv) {
        recordDataEntry.id = $('#cong-name').val();
        this.classList.contains('tableCongDate') && ii == 1 ? recordDataEntry.start_date = $(this).text() : '';
        this.classList.contains('tableCongDate') && ii == 2 ? recordDataEntry.end_date = $(this).text() : '';
        if(ii == 2){
          recordData.push(recordDataEntry);
          recordDataEntry = {};
        }
      }); 
    })
  
    json = JSON.stringify(recordData, null, 2);
    ajax.submitCongregationBlackouts('processBlackouts', json);
  }
}
