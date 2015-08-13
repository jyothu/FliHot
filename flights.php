<?php
session_start();
include 'db/db.php';
include 'vendor/autoload.php';

$query = 'SELECT code,name FROM `airports`';
$result = $connect->query($query) or trigger_error($connect->error."[$query]");

$airports = array();
while( $row = $result->fetch_row() )
  array_push( $airports, $row );

if( !isset( $_SESSION['SessionId'] ) ){

    $mistiFly = new Api\MistiFly();
    $_SESSION['SessionId'] = $mistiFly->CreateSession();

} 

?>
<div class="col-sm-12 search-form">

  <form id="flight-form">
    <div class="col-sm-12">
      <label class="radio-inline">
        <input type="radio" name="trip_type" id="trip_type" value="OneWay" checked="checked"> One Way
      </label>
      <label class="radio-inline">
        <input type="radio" name="trip_type" id="trip_type" value="Return"> Round Trip
      </label>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
        <label for="inputEmail3">From</label>        
        <select name="dep_city" class="form-control" required>
          <option>Select City</option>
          <?php
          foreach($airports as $airport) { ?>
            <option value="<?php echo $airport[0];?>"><?php echo $airport[1]; ?></option>
          <?php
          }
          ?>
        </select> 
      </div>
      <div class="form-group">
        <label for="inputPassword3">Depart On</label>        
        <div class='input-group date flight-datetimepicker'>
        <input type='text' name="departure" class="form-control" id="departure" required/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
    </div>

    <div class="col-sm-3">
      <div class="form-group">
        <label for="inputEmail3">To</label>        
        <select name="arr_city" class="form-control" required>
          <option>Select City</option>
          <?php
          foreach($airports as $airport) { ?>
            <option value="<?php echo $airport[0];?>"><?php echo $airport[1]; ?></option>
          <?php
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="inputPassword3">Return On</label>        
        <div class='input-group date flight-datetimepicker'>
        <input type='text' name="return" class="form-control" id="return"/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
        <label for="inputPassword3">Adults</label>        
        <input type='number' name="adults" class="form-control" id="adults" required/>
      </div>
      <div class="form-group">
        <label for="inputPassword3">Children</label>        
        <input type='number' name="children" class="form-control" id="children" required/>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group">
        <button type="submit" class="btn btn-default" id="submit">SEARCH</button>
      </div>
    </div>
  </form>
</div>

<div class="col-sm-12 search-result">
  <div id="result">
    <h5>No Results Found!!</h5>
  </div>
</div>

