<?php
include 'db/db.php';

$query = "SELECT id,name FROM `hotels` WHERE `city_id`='".$_POST['city']."'";
$hotels = $connect->query($query) or trigger_error($connect->error."[$query]");

echo '<option>Select Hotel</option>';
while($row = $hotels->fetch_row())
    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
?>