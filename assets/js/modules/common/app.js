$(document).ready(function() {
	$('#calendar').fullCalendar({
		// put your options and callbacks here
	});
	var bus = {
		init: function() {
   
		},
		getBlackoutDates: function() {
			console.log('getBlackoutDates');
			$.ajax({
				url:"http://localhost/schedulr/bus/get_blackoutDates",
				type: 'POST',
				dataType: 'JSON',
				success : function(data) {
					console.log('success\n');
					console.log(data);
				},
				error : function(data) {
					console.log('error\n');
					console.log(data);
				}
			});
	   	}
	}
	bus.getBlackoutDates();
});
