/* main function to run when the DOM is ready */
$(document).ready(function() {
	
	//assign and configure a date picker to the div 
	$("#date-picker").multiDatesPicker({
		inline: true,
		altField: "#bus-date",
	});


	//change the text field when a new date is selected
	$("#bus-date").change(function(){
		$("#date-picker").multiDatesPicker("setDate", $(this).val());
	});

});
