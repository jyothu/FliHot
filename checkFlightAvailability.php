<?php
session_start();
include "vendor/autoload.php";
$params = array();

$params["rq"]["SessionId"] = $_SESSION['SessionId'];
$params["rq"]["OriginDestinationInformations"]["OriginDestinationInformation"]["DepartureDateTime"] = $_POST['departure'];
$params["rq"]["OriginDestinationInformations"]["OriginDestinationInformation"]["DestinationLocationCode"] = $_POST['arr_city'];
$params["rq"]["OriginDestinationInformations"]["OriginDestinationInformation"]["OriginLocationCode"] = $_POST['dep_city'];
$params["rq"]["TravelPreferences"]["MaxStopsQuantity"] = 'All';
$params["rq"]["TravelPreferences"]["CabinPreference"] = 'Y';
$params["rq"]["TravelPreferences"]["AirTripType"] = $_POST['trip_type'];
$params["rq"]["PricingSourceType"] = "All";
$params["rq"]["PassengerTypeQuantities"]["PassengerTypeQuantity"][0]["Code"] = 'ADT';
$params["rq"]["PassengerTypeQuantities"]["PassengerTypeQuantity"][0]["Quantity"] = $_POST['adults'];
$params["rq"]["PassengerTypeQuantities"]["PassengerTypeQuantity"][1]["Code"] = 'CHD';
$params["rq"]["PassengerTypeQuantities"]["PassengerTypeQuantity"][1]["Quantity"] = $_POST['children'];
$params["rq"]["RequestOptions"] = "Fifty";
$params["rq"]["Target"] = 'Test';
$params["rq"]["IsRefundable"] = 0;


$mistiFly = new Api\MistiFly();
$flights = $mistiFly->soapCall( $params, 'AirLowFareSearch' );

// print_r( $flights );

if($flights->Success != 'true' ) {
    $flightErrors = $flights->Errors;
    foreach ($flightErrors as $errors)
        foreach ($errors as $error)
            echo "<span class='display-block'>".$error->Message."</span>";

} else {
    
    $itineraries = $flights->PricedItineraries->PricedItinerary;
    $seatsAvailable = "";
    $seatsUnAvailable = "";
    foreach ( $itineraries as $key=>$value) {
        $totalFare = $value->AirItineraryPricingInfo->ItinTotalFare->TotalFare->Amount;
        $totalFareCurrency = $value->AirItineraryPricingInfo->ItinTotalFare->TotalFare->CurrencyCode;
        $refundable = $value->AirItineraryPricingInfo->IsRefundable;
        $uniqFareCode = $value->AirItineraryPricingInfo->FareSourceCode;
        $passportMandatory = $value->IsPassportMandatory;
        $ticketType = $value->TicketType;
        
        foreach ($value->OriginDestinationOptions as $originDestinationOption) {

            foreach ($originDestinationOption->FlightSegments as $flightSegments) {
                if( !is_array( $flightSegments ) )
                    $flightSegmentz[0] = $flightSegments;
                else
                    $flightSegmentz = $flightSegments;

                foreach ($flightSegmentz as $flightSegment) {

                    if( $flightSegment->FlightNumber ){
                        $flightNo = $flightSegment->FlightNumber;
                        $duration = $flightSegment->JourneyDuration;
                        $flightCode = $flightSegment->MarketingAirlineCode; 
                        $depCity = $flightSegment->DepartureAirportLocationCode;
                        $arrCity = $flightSegment->ArrivalAirportLocationCode;
                        $depTime = $flightSegment->DepartureDateTime;
                        $arrTime = $flightSegment->ArrivalDateTime;
                        $cabin = $flightSegment->CabinClassCode;
                        $seatsRemaining = $flightSegment->SeatsRemaining->Number;
                        $html = "<tr><td><span class='display-block'>Total Fare per person : ".$totalFare." ".$totalFareCurrency."</span>";
                        $html .= "<span class='display-block'>Refundable : ".$refundable."</span>";
                        $html .= "<span class='display-block'>Is Passport Mandatory : ".($passportMandatory == true ? 'Yes' : 'No')."</span>";
                        $html .= "<span class='display-block'>Ticket Type : ".$ticketType."</span></td>";
                        $html .= "<td><span class='display-block'>".$flightCode." ".$flightNo."</span>";
                        $html .= "<span class='display-block'>Class : ".$cabin."</span>";
                        $html .= "<span class='display-block'>Duration : ".$duration." Minutes</span></td>";
                        $html .= "<td><span class='display-block'>".$depCity."</span>";
                        $html .= "<span class='display-block'>Date : ".$depTime."</span></td>";
                        $html .= "<td><span class='display-block'>".$arrCity."</span>";
                        $html .= "<span class='display-block'>Date : ".$arrTime."</span></td>";
                        $html .= "<td><span class='display-block'>".$seatsRemaining."</span></td></tr>";
                        $seatsRemaining > 0 ? ($seatsAvailable .= $html) : ($seatsUnAvailable .= $html);
                    }
                } 
            }
        }

    }

    $tableHeader = "<table class='table table-striped'><th>Itinerary Details</th><th>Flight No.</th><th>Departure</th>
    <th>Arrival</th><th>Seats Available</th>";

    echo "<div class='itinerary col-sm-12'>";
    echo "<ul id='tabs' class='nav nav-tabs' data-tabs='tabs'>";
    echo "<li class='active'><a href='#available' data-toggle='tab'>Seats Available</a></li>";
    echo "<li><a href='#all' data-toggle='tab'>All</a></li>";
    echo "</ul>";
    echo "<div id='my-tab-content' class='tab-content'>";
    echo "<div class='tab-pane active' id='available'>".$tableHeader.$seatsAvailable."</table></div>";
    echo "<div class='tab-pane' id='all'>".$tableHeader.$seatsAvailable.$seatsUnAvailable."</table></div>";
    echo "</div>";
    echo "</div>";
}

?>