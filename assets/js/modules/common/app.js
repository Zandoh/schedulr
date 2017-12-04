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

	//run function on the congregation schedule page
	if($("body").hasClass("cong-schedule")) {

		// tip for usability
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
		cong_schedule.init();

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

		// tip for usability
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
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

		// tip for usability
		$(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	}

	if($("body").hasClass("guest")) {
		var doc = new jsPDF();
		var rotation = $('.scheduleToPDF h2').text().replace(/ /g,'').toLowerCase();

		$('#pdfMe').click(function () {
				doc.fromHTML($('.scheduleToPDF').html(), 15, 15);
				doc.save('congregation_schedule_'+rotation+'.pdf');
		});
	}

});
