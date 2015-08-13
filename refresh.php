<?php
include 'db/db.php';

$query = 'SELECT id,name FROM `cities`';
$cities = $connect->query($query) or trigger_error($connect->error."[$query]");
$curl = curl_init();

while($row = $cities->fetch_row()) {
  $params = array("buyer_id" => 11,
  	"key" => "AXR-ECT",
  	"city" => $row[1],
  	"check_in_date" => stripslashes('25/08/2015'),
  	"check_out_date" => stripslashes('27/08/2015'),
  	"rooms" => 1,
  	"roomwisePax" => array(array("roomNo" => 1, "num_adults" => 1, "num_children" => 1)),
  	"corporate_buyer_id" => 123
  	);
  $jsonParams = str_replace('\/', '/', json_encode($params, JSON_UNESCAPED_SLASHES));
  curl_setopt($curl, CURLOPT_URL,            "http://52.24.104.85:8080/hexapi/hotelsearch" );
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt($curl, CURLOPT_POST,           1 );
  curl_setopt($curl, CURLOPT_POSTFIELDS,     $jsonParams ); 
  curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 

  $hotels = curl_exec( $curl );
  foreach( json_decode($hotels, true)["hotels"] as $hotel ){
    $query = "INSERT INTO `hotels` (`id`, `name`, `city_id`) VALUES ('".$hotel['id']."','".$hotel['name']."', '".$row[0]."')";
    $connect->query($query) or trigger_error($connect->error."[$query]");
  }
}
curl_close($curl);
?>