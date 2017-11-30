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

		// tip for usability
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
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
