<?php

  $curl = curl_init();

  $params = array("buyer_id" => 11,
  	"key" => "AXR-ECT",
  	"hotel_id" => $_POST["hotel"],
  	"start_date" => stripslashes($_POST["checkin"]),
  	"end_date" => stripslashes($_POST["checkout"]),
  	"rooms" => array(array("roomNo" => 1, "num_adults" => $_POST["people"], "num_children" => 0)),
  	"corporate_buyer_id" => 123
  	);

  $jsonParams = str_replace('\/', '/', json_encode($params, JSON_UNESCAPED_SLASHES));
  curl_setopt($curl, CURLOPT_URL,            "http://52.24.104.85:8080/hexapi/checkavailibility" );
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt($curl, CURLOPT_POST,           1 );
  curl_setopt($curl, CURLOPT_POSTFIELDS,     $jsonParams ); 
  curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 

  $jsonResponse = curl_exec( $curl );
  $availableRooms = json_decode($jsonResponse, true);
  echo "<table class='table table-striped'><th>Room ID</th><th>Room Name</th><th>Room Details</th><th>Rate Plans</th>";
  if( !empty($availableRooms) ) {
    foreach( $availableRooms["rooms"] as $room ){
      echo "<tr><td>".$room["room_id"]."</td><td>".$room["room_name"]."</td>
      <td>".$room["room_details"]."</td><td>
      <table class='table table-striped'><th>Plan ID</th><th>Code</th><th>Details</th><th>Rack Rate</th><th>Contracted Price</th>";
      foreach( $room["rateplans"] as $rateplan ){
        echo "<tr><td>".$rateplan["rateplan_id"]."</td><td>".$rateplan["code"]."</td>
        <td>".$rateplan["details"]."</td><td>".$rateplan["rack_rate"]."</td><td>
        <table class='table table-striped'><th>Buyer ID</th><th>Price</th><th>Description</th>";
        foreach( $rateplan["contracted_price_details"] as $price ){
          echo "<tr><td>".$price["buyer_id"]."</td><td>".$price["price"]."</td><td>".$price["description"]."</td></tr>";
        }
        echo "</table></td></tr>";
      }
      echo "</table></td></tr>";
    }
  }else{
    echo "No results Found!!";
  }

  curl_close($curl);

?>