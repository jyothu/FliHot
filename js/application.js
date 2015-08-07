$(document).ready(function(){
	$('.datetimepicker').datetimepicker({
		format: 'DD/MM/GGGG'
	});

	// Refresh tables - Cities, Hotels
	// setInterval(function() {
	// 	$.ajax( { url: 'refresh.php' } );
	// }, 100000);

  // Refresh Hotels drop down dynamically
  $("#city").change(function(){
     callAjaxForCityHotels( $(this).val() );
	});

  var callAjaxForCityHotels = function( city ){
 	  $.ajax({
        type: "post",
        url: "getHotels.php",
        data: "city="+city,
        success: function( data ) {
          $("#hotel").html( data );
        }
    });
  }

  $( "form" ).on( "submit", function( event ) {
		event.preventDefault();
		checkAvailability( $(this) );
	});

	var checkAvailability = function( myForm ){
		$.ajax({
	      type: "post",
	      url: "checkAvailability.php",
	      data: myForm.serialize(),
	      success: function( data ) {
	        $("#result").html( data );
	      }
	    });
	}

});

