/* Main function to run when the DOM is ready */
$(document).ready(function() {
	
	if($("body").hasClass("bus")) {
		bus.init();

		// assign and configure a date picker to the div 
		$("#date-picker").multiDatesPicker({
			inline: true,
			altField: "#bus-date"
		});
		
		// change the text field when a new date is selected
		$("#bus-date").change(function(){
			$("#date-picker").multiDatesPicker("setDate", $(this).val());
		});
	}

	// run functions on the admin page
	if($("body").hasClass("admin")) {
		admin.init();
	}

	// run functions on the login page
	if($("body").hasClass("init_login")) {
		login.init();
	}

	if($("body").hasClass("bus-schedule")) {
		bus_schedule.init();

		// assign and configure a date picker to the div
		$("#bus-schedule").multiDatesPicker({
			inline: true,
			maxPicks: 1,
			altField: "#alt-Input",
			onSelect: function() {
				//assign the "Day" label to be the date the user selected
				var hiddenDate = $("#alt-Input").attr('value');
				$("#schedule-header-date").text(hiddenDate);
				console.log(hiddenDate);
			}
		});

	}

});
