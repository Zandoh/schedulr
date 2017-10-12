console.log('bus-test');
$(document).ready(function() {
	$('#calendar').fullCalendar({
		// editable: false, // Don't allow editing of events
		// handleWindowResize: true,
		// weekends: false, // Hide weekends
		// defaultView: 'agendaWeek', // Only show week view
		// header: false, // Hide buttons/titles
		// minTime: '07:30:00', // Start time for the calendar
		// maxTime: '22:00:00', // End time for the calendar
		// columnFormat: {
		// 	week: 'ddd' // Only show day of the week names
		// },
		// displayEventTime: true, // Display event time
	});
	var event={id:1 , title: 'New event', start:  new Date()};
	$('#calendar').fullCalendar('renderEvent', event, true);

	var event={id:2 , title: 'New event2', start:  new Date()};
	$('#calendar').fullCalendar('renderEvent', event, true);

	var event={id:3 , title: 'New event3', start:  new Date()};
	$('#calendar').fullCalendar('renderEvent', event, true);

	var event={id:4 , title: 'New event4', start:  new Date()};
	$('#calendar').fullCalendar('renderEvent', event, true);
});

console.log('cong-test');
console.log('helllllooooo');