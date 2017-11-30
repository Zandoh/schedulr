var ajax = {
	/* 
  * Method: ajaxCall(param, param)
  * Description: ajax helper method, returns a jQuery ajax object
	* @param: getOrPost: {"GET", "POST"} define the type of method the ajax call will use
	* @param: data: optional, data to be passed in with the ajax call.
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
	* @param: data: optional, data to be passed in with the ajax call.
	* 
	* Description: returns admin users
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
	* @param: data: optional, data to be passed in with the ajax call.
	*
	* Description: gets all drivers to populate a select/option element
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
									ajax.getDriverAvailability('returnDriverAvailability', user.id);
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
	* @param: data: optional, data to be passed in with the ajax call.
	*
	* Description: gets the availability for a specific driver
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
        html +=   '<td class="tableDriverTime" >' + driver.time.toUpperCase() + '<a id="delete-date"><i class="fa fa-minus-circle fa-lg pull-right" aria-hidden="true"></i></a></td>';
        html += '</tr>';  
    
        table.append(html);
			});
		}).fail(function(err) {
      // console.log(err);
    });
	},

	/* 
	* Method: getAvailabilityByDay(param, param)
	*
	* @param: func: function to be called in the "file" attribute. Ex "returnAdminUsers"
	* @param: data: optional, data to be passed in with the ajax call.
	* 
	* Description: gets a all drivers who are available on a selected day
  */
	getAvailabilityByDay: function(func, data) {
		ajax.ajaxCall("GET", {
			method: func, 
			data: data,
      file: "busDriver_handler"
    }).done(function(jsonResponse) {
			var table = $('table#schedule-list tbody');
			table.empty();
			$.each($.parseJSON(jsonResponse), function (i, driver) {
				html =  '<tr>';
        html +=   '<td scope="row" class="tableDriverName" data-id="'+driver.userID+'">' + driver.firstName + ' ' + driver.lastName +'</td>';
        html +=   '<td class="tableDriverTime" >' + driver.time.toUpperCase() + '</td>';
        html += '</tr>';  
    
        table.append(html);
			});
		}).fail(function(err) {
      // console.log(err);
    });
	},
	/* 
	* Method: submitBusDriverAvailability(param, param)
	*
	* @param: func: function to be called in the "file" attribute. Ex "returnAdminUsers"
	* @param: data: optional, data to be passed in with the ajax call.
	*
	* Description: submits an entire drivers availability, full dump and replace
  */
	submitBusDriverAvailability: function(func, data) {
		ajax.ajaxCall("GET", {
			method: func, 
			data: data,
      file: "busDriver_handler"
    }).done(function(jsonResponse) {
			console.log('submitBusDriverAvailability.done()....');
			console.log(jsonResponse);
		}).fail(function(err) {
      // console.log(err);
    });
	}

}
