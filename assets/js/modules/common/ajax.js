var ajax = {

	ajaxCall: function(getOrPost, data) {
		return $.ajax({
			type: getOrPost,
			async: true,
			cache: false,
      url: "mid.php",
      data: data
		});
	},
	
	getUsers: function(func, data) {
		ajax.ajaxCall("GET", {
      method: func, 
      file: "admin_handler"
    }).done(function(jsonObj) {
      console.log(jsonObj);
      //do work with response json here
		}).fail(function(err) {
      console.log(err);
    });
	}
}