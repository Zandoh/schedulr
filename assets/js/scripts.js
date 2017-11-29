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
    * Validate to make sure users are added and edited appropriately
    */
    admin.validateAddUser();
    admin.validateEditUser();

    /*
    * Validate to make sure congregations are added and edited appropriately
    */
    admin.validateEditCong();
    admin.validateAddCong();
  },

  /*
  * Method: validateAddUser
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button for adding Users. Returns true if validate, else returns error.
  */
  validateAddUser: function() {
    
    $("form[name='addUserSubmit']").validate({ // use validation plugin
      rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 8,
            maxlength: 50
          },
          phoneNumber: {
            required: true,
            phoneUS: true
          },
          firstName: {
            required: true,
            maxlength: 200
          },
          lastName: {
            required: true,
            maxlength: 200
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  },

  /*
  * Method: validateEditUser
  * Description: Function to check for blank fields in the edit user functionality
  * Usage: Called when the user clicks on the edit user Submit button. Returns true if validate, else returns error.
  */
  validateEditUser: function() {
    
    $("form[name='editUserSubmit']").validate({ // use validation plugin
      rules: {
          email: {
            required: true,
            email: true
          },
          phoneNumber: {
            required: true,
            phoneUS: true
          },
          firstName: {
            required: true,
            maxlength: 200
          },
          lastName: {
            required: true,
            maxlength: 200
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  },

  /*
  * Method: validateEditCong
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button for editing congregations. Returns true if validate, else returns error.
  */
  validateEditCong: function() {
    
    $("form[name='editCongSubmit']").validate({ // use validation plugin
      rules: {
          congregation_name: {
            required: true,
            maxlength: 200
          },
          congregation_phone: {
            required: true,
            phoneUS: true
          },
          congregation_street_address: {
            required: true,
            maxlength: 200
          },
          congregation_city: {
            required: true,
            maxlength: 200
          },
          congregation_state: {
            required: true,
            minlength: 2,
            maxlength: 2,
            lettersonly: true
          },
          congregation_zip: {
            required: true,
            minlength: 5,
            maxlength: 5,
            number: true
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  },

  /*
  * Method: validateAddCong
  * Description: Function to check for blank fields
  * Usage: Called when the user clicks on the Submit button for adding congregations. Returns true if validate, else returns error.
  */
  validateAddCong: function() {
    
    $("form[name='addCongSubmit']").validate({ // use validation plugin
      rules: {
          congregation_name: {
            required: true,
            maxlength: 200
          },
          congregation_phone: {
            required: true,
            phoneUS: true
          },
          congregation_street_address: {
            required: true,
            maxlength: 200
          },
          congregation_city: {
            required: true,
            maxlength: 200
          },
          congregation_state: {
            required: true,
            minlength: 2,
            maxlength: 2,
            lettersonly: true
          },
          congregation_zip: {
            required: true,
            minlength: 5,
            maxlength: 5,
            number: true
          }
      },
      submitHandler: function (form) { // return true if everything validates
        form.submit();
      }
    })

  }


}
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
    console.log("bus schedule test");
    
    //bind ui date picker on change
      //get the value of the selected date
      //make request to backend function with the date
      //get returned a list of people available that day

  }

    
}

var bus = {
  /*
  * Method: init()
  * Description: initializes the bus namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    // a function to fetch the bus drivers then populate the select option 
    // also gets availability data and populates it into the table
    this.populateDrivers();
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
      
      // make sure fields aren't empty
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
      var optionSelected = $("option:selected", this);
      var valueSelected = this.value;
      
      if(valueSelected != '') {
        ajax.getDriverAvailability('returnDriverAvailability', valueSelected);
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
    var driverName = $('#bus-name').find(":selected").text();
    var driverDates = $('#bus-date').val();
    var driverDatesArray = driverDates.split(', ');
    var driverTime = $('#bus-time').val();
    var table = $('table#list tbody');

    var exists = bus.checkExists(driverDatesArray);

    if(exists == false) {
      for(var i = 0; i < driverDatesArray.length; i++) {
        html =  '<tr>';
        html +=   '<td scope="row" class="tableDriverName">' + driverName +'</td>';
        html +=   '<td class="tableDriverDate">' + driverDatesArray[i] + '</td>';
        html +=   '<td class="tableDriverTime" >' + driverTime + '<a id="delete-date"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
      }
    }
  },

  /*
  * Method: checkExists()
  * @param: date - selected date(s) from the calendar as an array
  * Description: utility to check if a date already exists in the availability table
  * Returns: true or false
  */
  checkExists: function(dates) {
    var errorContainer = $('#error-container');
    errorContainer.empty();
    var table = $('table#list tbody');
    var tableRows = $('table#list tbody > tr > td.tableDriverDate');
    if(tableRows.length > 0) {
      $.each(dates, function(i, date) {
        $.each(tableRows, function(j, rowDate) {
          var currentRowDate = $(rowDate).text();
          if(currentRowDate == date) {
            errorContainer.append('<p>Availability Already Exists on ' + date + '</p>');
          }
        });
      });
    } else {
      return false;
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
        // will we need the id??
        recordDataEntry.id = $('#bus-name').val();
        this.classList.contains('tableDriverName') ? recordDataEntry.name = $(this).text() : '';
        this.classList.contains('tableDriverDate') ? recordDataEntry.date = $(this).text() : '';
        this.classList.contains('tableDriverTime') ? recordDataEntry.time = $(this).text() : '';
        ii == 2 ? recordData.push(recordDataEntry) : '';
      }); 
    })
  
    json = JSON.stringify(recordData, null, 2);
    console.log(json);
    // backend will need a function we can make a POST request to submit this data
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
      // do work with response json here
		}).fail(function(err) {
      // console.log(err);
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
				if(user.type == "b"){
					$("select#bus-name option").each(function() {
							if ($(this).val() == user.id) {
									$(this).attr("selected","selected");
									$('#bus-name').attr("disabled","disabled");
							}
					});
				}
		}).fail(function(err) {
      // console.log(err);
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
			var table = $('table#list tbody');
			var driverName = $('#bus-name').find(":selected").text();
			var html;

			table.empty();
			
			$.each($.parseJSON(jsonResponse), function (i, driver) {
				html =  '<tr>';
        html +=   '<td scope="row" class="tableDriverName">' + driverName +'</td>';
        html +=   '<td class="tableDriverDate">' + driver.date + '</td>';
        html +=   '<td class="tableDriverTime" >' + driver.time + '<a id="delete-date"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
			});
		}).fail(function(err) {
      // console.log(err);
    });
	},

	getAvailabilityByDay: function(func, data) {
		ajax.ajaxCall("GET", {
			method: func, 
			data: data,
      file: "busDriver_handler"
    }).done(function(jsonResponse) {
			var table = $('table#schedule-list tbody');
			$.each($.parseJSON(jsonResponse), function (i, driver) {
				html =  '<tr>';
        html +=   '<td scope="row" class="tableDriverName" data-id="'+driver.userID+'">' + driver.firstName + ' ' + driver.lastName +'</td>';
        html +=   '<td class="tableDriverTime" >' + driver.time + '</td>';
        html += '</tr>';  
    
        table.append(html);
			});
		}).fail(function(err) {
      // console.log(err);
    });
	}

}

/* Main function to run when the DOM is ready */
$(document).ready(function() {
	
	if($("body").hasClass("bus")) {
		bus.init();

		// assign and configure a date picker to the div 
		$("#date-picker").multiDatesPicker({
			inline: true,
			altField: "#bus-date",
			dateFormat: "yy-mm-dd"
		});
		
		// change the text field when a new date is selected
		$("#bus-date").change(function(){
			$("#date-picker").multiDatesPicker("setDate", $(this).val());
		});
	}

	// run functions on the admin page
	if($("body").hasClass("admin")) {
		admin.init();
		//Toggle congregation select on the admin page
	    $('#add-user-type').change(function(){
	      var selection = $(this).val();
	      if(selection == 'c'){
	          $('#congregation-select-div').show();
	      }  
	      else{
	          $('#congregation-select-div').hide();
	      } 
	    });
	}

	// run functions on the login page
	if($("body").hasClass("init_login")) {
		login.init();
	}

	//run functions on the blackout page
	if($("body").hasClass("cong-blackouts")) {
		cong_blackouts.init();

		// assign and configure a date picker to the div
		$("#blackout-calendar").multiDatesPicker({
			inline: true,
			altField: "#cong-date",
			maxPicks: 1,
			dateFormat: "yy-mm-dd"
		});
	}

	if($("body").hasClass("bus-schedule")) {
		bus_schedule.init();

		// assign and configure a date picker to the div
		$("#bus-schedule").multiDatesPicker({
			inline: true,
			maxPicks: 1,
			dateFormat: "yy-mm-dd",
			altField: "#alt-Input",
			onSelect: function() {
				//assign the "Day" label to be the date the user selected
				var hiddenDate = $("#alt-Input").attr('value');
				$("#schedule-header-date").text(hiddenDate);
				ajax.getAvailabilityByDay('returnAvailabilityOnDay', hiddenDate);
			}
		});

	}

	if($(".generatePDF")){
		//bind click events 
			//utils.saveAsPDF();
	}

});

var utils = {
	saveAsPDF: function() {
		//going to tie this to a button click event
		//each schedule that needs to be saved as a PDF will have a data-attribute on it as data-pdfMe="1"
		//get that div with the data-attribute
	}
};

var login = {
  /*
  * Method: init()
  * Description: initializes the login namespace
  * Usage: Called in App.js
  */
  init: function() {
    this.bindEvents();
    //will validate the login form
    //will validate the email reset form
  },

  /* 
  * Method: bindEvents()
  * Description: Function to bind all events for html elements
  * Usage: called when the login is initialized
  */
  bindEvents: function() {
    /*
    * Validate to make sure login and email is entered correctly
    */
    login.validateLogin();
    login.validateEmail();
    login.validatePassword();

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

  },

  /*
  * Method: validateEmail
  * Description: Function to validate if an email is entered
  * Usage: Called when the user clicks on the Password Reset button. Returns true if validate, else returns error.
  */
  validateEmail: function() {

    $("form[name='passwordReset']").validate({ //use validation plugin
      rules: {
        account: {
          required: true,
          email: true
        }
      },
      submitHandler: function(form) { //return true if everything validates 
        form.submit();
      },
      messages: { //messages to return if field is not email or empty
        account: {
          required: "Can't leave email empty"
        }
      }
    })
  },


  /*
  * Method: validatePassword
  * Description: Function to validate a password change
  * Usage: Called when the user clicks on the Reset Password button. Returns true if validate, else returns error.
  */
  validatePassword: function() {
    
        $("form[name='newFormPassword']").validate({ // use validation plugin
          rules: {
            password: {
              required: true,
              minlength: 8,
              maxlength: 50
            },
            confirm: {
              required: true,
              equalTo: "#newPassword"
            }
          },
          submitHandler: function(form) { // return true if everything validates 
            form.submit();
          },
          messages: { // messages to return if field is not email or empty
            password: {
              required: "Can't leave password empty"
            },
            confirm: {
              equalTo: "Your confirmed password doesn't match"
            }
          }
        })
  }

}

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
    console.log("blackouts test");
  }

    
}

var user = {
    type: null,
    id: null
};
