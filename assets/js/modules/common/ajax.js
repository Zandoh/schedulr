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
      // do work with response json here
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
			console.log('availability here......');
			console.log(jsonResponse);
			$.each($.parseJSON(jsonResponse), function (i, driver) {
				// append items to the table here
			});
      // do work with response json here
		}).fail(function(err) {
      // console.log(err);
    });
	}

}