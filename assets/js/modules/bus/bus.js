var bus = {
  /*
  * Method: init()
  * Description: initializes the bus namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    this.populateDrivers();
    //will a function to fetch the bus drivers then populate the select option 
      //also get availability data and populate it into the table
  },

  /* 
  * Method: populateDrivers()
  * Description: Function to make an ajax call to fetch driver data
  * Usage: Called when bus is initalized
  */
  populateDrivers: function() {
    ajax.getDrivers('returnDrivers');
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: Called when bus is initalized
  */
  bindEvents: function() {
    $('.add-to-list').on('click', function(e) {
      var error = false;
      
      e.preventDefault();
      
      $("#error-container").empty();
      
      if($('#bus-name').val() == "") {
        error = true;
        $('#error-container').append("<p>A driver is required.</p>");
      }
      
      if($('#bus-date').val() == "") {
        error = true;
        $('#error-container').append("<p>Date(s) is/are required.</p>");
      }
      
      if($('#bus-time').val() == "") {
        error = true;
        $('#error-container').append("<p>Time is required.</p>");
      }

      if(!error){
        bus.populateTable();
      }
    });

    $('#driver-avail-submit').on('click', function(e) {
      e.preventDefault();
      bus.submitAvailability();
    });

    /* 
    * Interpreted as a click event on the anchor tag with an ID of delete-date
    * This syntax is used since the anchor tags are dynamically generated
    */
    $('table#list').on('click', 'a#delete-date', function(e) {
      e.preventDefault();
      bus.removeDriverRecord(this);
    });

    $('#bus-name').on('change', function (e) {
      console.log('changed......');
      var optionSelected = $("option:selected", this);
      var valueSelected = this.value;
      
      if(valueSelected != '') {
        console.log('not null');
        console.log(valueSelected);
        ajax.getDriverAvailability('returnDriverAvailability', valueSelected);
        //need to fetch their availability here. Then populate them into the table.
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
      var driverName = $('#bus-name').find(":selected").text();;
      var driverDates = $('#bus-date').val();
      var driverDatesArray = driverDates.split(',');
      var driverTime = $('#bus-time').val();
      var table = $('table#list tbody');

      for(var i = 0; i < driverDatesArray.length; i++) {
        html =  '<tr>';
        html +=   '<td scope="row" class="tableDriverName">' + driverName +'</td>';
        html +=   '<td class="tableDriverDate">' + driverDatesArray[i] + '</td>';
        html +=   '<td class="tableDriverTime" >' + driverTime + '<a id="delete-date"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
      }
  },

  /*
  * Method: removeDriverRecord()
  * Description: Removes a record from the List of Dates table
  * Usage: Called from the click event of the delete icon
  */
  removeDriverRecord: function(anchor) {
    $(anchor).parents().closest('tr').empty().remove();
  },

  /*
  * Method: submitAvailability()
  * Description: Function helper to convert form data into JSON to handle on the backend
  * Usage: Called from the click event of the Submit button on the Driver Availability page
  * Sample JSON:
  * [
  *   {
        "id": "1"
  *     "name": "John Doe",
  *     "date": "YYYY-MM-DD",
  *     "time": "AM | PM | Both"
  *   }
  * ]
  */
  submitAvailability: function() {
    var table = $('table#list tbody');
    var allTableRecords = table.find('tr');
    var recordData = [];
    var recordDataEntry = {};
    var json;
    
    $(allTableRecords).each(function(i, v) {
      $(this).children('td').each(function(ii, vv) {
        //will we need the id??
        recordDataEntry.id = $('#bus-name').val();
        this.classList.contains('tableDriverName') ? recordDataEntry.name = $(this).text() : '';
        this.classList.contains('tableDriverDate') ? recordDataEntry.date = $(this).text() : '';
        this.classList.contains('tableDriverTime') ? recordDataEntry.time = $(this).text() : '';
        ii == 2 ? recordData.push(recordDataEntry) : '';
      }); 
    })
  
    json = JSON.stringify(recordData, null, 2);
    console.log(json);
    //backend will need a function we can make a POST request to submit this data
  }
}
