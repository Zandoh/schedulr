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

    var exists = cong_blackouts.checkExists(congDate);

    if(exists == false) {
        html =  '<tr>';
        html +=   '<td scope="row" class="tableCongName">' + congName +'</td>';
        html +=   '<td class="tableCongDate">' + congDate + '</td>';
        html +=   '<td class="tableCongTime" ><a id="delete-date"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
    }
  },

  /*
  * Method: checkExists()
  * @param: date - selected date from the calendar
  * Description: utility to check if a date already exists in that week
  * Returns: true or false
  */
  checkExists: function(dates) {
    var errorContainer = $('#error-container');
    var table = $('table#list tbody');
    var tableRows = $('table#list tbody > tr > td.tableCongDate');
    var exists = false;

    errorContainer.empty();

    

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
