$(document).ready(function(){
	$('.datetimepicker').datetimepicker({
		format: 'DD/MM/GGGG'
	});

    $('.flight-datetimepicker').datetimepicker({
		format: 'GGGG-MM-DDT00:00:00'
	});
    
    $('#tabs').tab();

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

    $( "#form" ).on( "submit", function( event ) {
		event.preventDefault();
		checkHotelAvailability( $(this) );
	});

	var checkHotelAvailability = function( myForm ){
		$.ajax({
	        type: "post",
	        url: "checkHotelAvailability.php",
	        data: myForm.serialize(),
	        success: function( data ) {
	            $("#result").html( data );
	        }
	    });
	}

    $( "#flight-form" ).on( "submit", function( event ) {
		event.preventDefault();
		checkFlightAvailability( $(this) );
	});

	var checkFlightAvailability = function( myForm ){
		console.log( myForm.serialize() );
		$.ajax({
	      type: "post",
	      url: "checkFlightAvailability.php",
	      data: myForm.serialize(),
	      success: function( data ) {
	        $("#result").html( data );
	      }
	    });
	}
});

