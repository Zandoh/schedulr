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
      e.preventDefault();
      bus.populateTable();
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
        //ajax.getDriverAvailability('returnDriverAvailability', valueSelected);
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

var ajax = {
	/* 
  * Method: ajaxCall(param, param)
  * Description: ajax helper method, returns a jQuery ajax object
	* @param: getOrPost: {"GET", "POST"} define the type of method the ajax call will use
	* @param: data: optional, data to be passed in with the ajax call. Only needed for POST requests
  */
	ajaxCall: function(getOrPost, data) {
		return $.ajax({
			type: getOrPost,
			async: true,
			cache: false,
      url: "mid.php",
      data: data
		});
	},
	
	/* 
  * Method: getUsers(param, param)
  * 
	* @param: getOrPost: {"GET", "POST"} define the type of method the ajax call will use
	* @param: data: optional, data to be passed in with the ajax call. Only needed for POST requests
  */
	getUsers: function(func, data) {
		ajax.ajaxCall("GET", {
      method: func, 
      file: "admin_handler"
    }).done(function(jsonResponse) {
			console.log('getting users..... ');
      console.log(jsonResponse);
      //do work with response json here
		}).fail(function(err) {
      //console.log(err);
    });
	},

	/* 
	* Method: getDrivers(param, param)
	*
	* @param: func: function to be called in the "file" attribute. Ex "returnAdminUsers"
	* @param: data: optional, data to be passed in with the ajax call. Only needed for POST requests
  */
	getDrivers: function(func, data) {
		ajax.ajaxCall("GET", {
      method: func, 
      file: "admin_handler"
    }).done(function(jsonResponse) {
			$.each($.parseJSON(jsonResponse), function (i, driver) {
				$('#bus-name').append($('<option>', { 
						value: driver.userID,
						text : driver.firstName + ' ' + driver.lastName
				}));
			});
			$('#bus-name').removeAttr('disabled');
      //do work with response json here
		}).fail(function(err) {
      //console.log(err);
    });
	},

	/* 
	* Method: getDriverAvailability(param, param)
	*
	* @param: func: function to be called in the "file" attribute. Ex "returnAdminUsers"
	* @param: data: optional, data to be passed in with the ajax call. Only needed for POST requests
  */
	getDriverAvailability: function(func, data) {
		ajax.ajaxCall("GET", {
			method: func, 
			data: data,
      file: "admin_handler"
    }).done(function(jsonResponse) {
			console.log('availability here......');
			console.log(jsonResponse);
			$.each($.parseJSON(jsonResponse), function (i, driver) {
				//append items to the table here
			});
      //do work with response json here
		}).fail(function(err) {
      //console.log(err);
    });
	}

}
/* main function to run when the DOM is ready */
$(document).ready(function() {
	
	if($("body").hasClass("bus")) {
		bus.init();

		//assign and configure a date picker to the div 
		$("#date-picker").multiDatesPicker({
			inline: true,
			altField: "#bus-date",
		});
		
		//change the text field when a new date is selected
		$("#bus-date").change(function(){
			$("#date-picker").multiDatesPicker("setDate", $(this).val());
		});
	}

	if($("body").hasClass("admin")) {
		admin.init();
	}

	if($("body").hasClass("init_login")) {
		login.init();
	}
});

var login = {
  /*
  * Method: init()
  * Description: initializes the login namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    //will validate the login processes
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: called when the login is initialized
  */
  bindEvents: function() {
    /*
    * Validate to make sure login is entered correctly
    */
    login.validateLogin();
    

  },

  /*
  * Method: validateLogin
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the LoginSubmit button. Returns true if validate, else returns error.
  */
  validateLogin: function() {
    
    $("form[name='loginForm']").validate({ //use validation plugin
      rules: {
          account: {
            required: true,
            email: true
          },
          secure: {
            required: true
          }
      },
      submitHandler: function (form) { //return true if everything validates
        form.submit();
      },

      messages: { //messages to return if fields are empty
        account: {  
          required: "Can't leave email empty"
        },
        secure: {
          required: "Can't leave password empty"
        }
      }
    })

  }

}

console.log('cong-test');
console.log('helllllooooo');
var admin = {
  /*
  * Method: init()
  * Description: initializes the admin namespace
  * Usage: Called in App.js
  */
  init: function() {
    ajax.getUsers('returnAdminUsers');
    this.bindEvents();
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: called when the login is initialized
  */
  bindEvents: function() {
    /*
    * Validate to make sure login is entered correctly
    */
    admin.validateLogin();

  },

  /*
  * Method: validateLogin
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button. Returns true if validate, else returns error.
  */
  validateLogin: function() {
    
    $("form[name='addUserSubmit']").validate({ //use validation plugin
      rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 8
          },
          phoneNumber: {
            required: true,
            phoneUS: true
          },
          firstName: {
            required: true
          },
          lastName: {
            required: true
          }
      },
      submitHandler: function (form) { //return true if everything validates
        form.submit();
      },
    })

  }


}