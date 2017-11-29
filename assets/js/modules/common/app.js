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
				//go get availabilities on this date
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
