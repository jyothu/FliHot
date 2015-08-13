<?php
include "vendor/autoload.php";

$params = array(
    "action" => "checkavailibility",
    "start_date" => stripslashes( $_POST["checkin"] ),
    "end_date" => stripslashes( $_POST["checkout"] ),
    "hotel_id" => stripslashes( $_POST["hotel"] ),
    "rooms" => array(array("roomNo" => 1, "num_adults" => $_POST["people"], "num_children" => 0)),
);

$axisRoom = new Api\AxisRoom( $params );
$availableRooms = $axisRoom->post();

if( !empty( $availableRooms ) ) {
    echo "<table class='table table-striped'><th>Room ID</th><th>Room Name</th><th>Room Details</th><th>Rate Plans</th>";
    foreach( $availableRooms["rooms"] as $room ){
        echo "<tr><td>".$room["room_id"]."</td><td>".$room["room_name"]."</td>
        <td>".$room["room_details"]."</td><td>
        <table class='table table-bordered'><th>Plan ID</th><th>Code</th><th>Details</th><th>Rack Rate</th><th>
        <table class='table'><tr><td colspan=3>Contracted Price</td></tr>
        <tr><td>Buyer ID</td><td>Price</td><td>Description</td></table></th>";
        
        foreach( $room["rateplans"] as $rateplan ){
            echo "<tr><td>".$rateplan["rateplan_id"]."</td><td>".$rateplan["code"]."</td>
            <td>".$rateplan["details"]."</td><td>".$rateplan["rack_rate"]."</td><td><table class='table table-striped'>";
        
            foreach( $rateplan["contracted_price_details"] as $price )
                echo "<tr><td>".$price["buyer_id"]."</td><td>".$price["price"]."</td><td>".$price["description"]."</td></tr>";
            
            echo "</table></td></tr>";
        }

        echo "</table></td></tr>";
    }

    echo "</table></td></tr>";

}else{

    echo "No results Found!!";

}

?>