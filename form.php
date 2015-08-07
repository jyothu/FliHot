<?php
include 'db/db.php';
  $query = 'SELECT id,name FROM `cities`';
  $cities = $connect->query($query) or trigger_error($connect->error."[$query]");
?>
<div class="col-sm-12 search-form">

  <form id="form">
    <div class="col-sm-4">
      <div class="form-group">
        <label for="inputEmail3">City</label>        
        <select name="city" class="form-control" id="city" required>
          <option>Select City</option>
          <?php
          while($row = $cities->fetch_row()) { ?>
            <option value="<?php echo $row[0];?>"><?php echo $row[1]; ?></option>
          <?php
          }
          ?>
        </select> 
      </div>
      <div class="form-group">
        <label for="inputEmail3">Hotel</label>        
        <select name="hotel" class="form-control" id="hotel" required></select> 
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label for="inputPassword3">CheckIn</label>        
        <div class='input-group date datetimepicker'>
        <input type='text' name="checkin" class="form-control" id="checkin" required/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3">CheckOut</label>        
        <div class='input-group date datetimepicker'>
          <input type='text' name="checkout" class="form-control" id="checkout" required/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label for="inputEmail3">No of Rooms</label>      
        <input type='number' name="rooms" min="1" class="form-control" id="rooms" required />
      </div>
      <div class="form-group">
        <label for="inputEmail3">No of Pax</label>      
        <input type='number' name="people" min="1" class="form-control" id="people" required/>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group">
        <button type="submit" class="btn btn-default" id="submit">Check Availability</button>
        <button type="reset" class="btn btn-default">Reset Results</button>
      </div>
    </div>
  </form>
</div>

<div class="col-sm-12 search-result">
  <div id="result">
    <h5>No Results Found!!</h5>
  </div>
</div>

