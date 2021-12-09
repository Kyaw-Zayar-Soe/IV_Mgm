<?php
  require '../init.php';
  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }
  require("../include/header.php");
?>
  <!-- Breadcamp -->
  <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white">Category</h4>
          > All
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
          <form>
              <div class="form-group">
                  <label>Enter Buy Price</label>
                  <input type="number" name="buy_price" class="form-control">
              </div>
              <div class="form-group">
                  <label>Total Quantity</label>
                  <input type="number" name="total_quantity" class="form-control">
              </div>              
              <div class="form-group">
                  <label>Enter Buy date</label>
                  <input type="date" value="<?php echo date('Y-m-d'); ?>" name="buy_date" class="form-control">
              </div>
              <input type="submit" value="Create" class="btn-warning">
          </form>
      </div>
    </div>
  </div>
  <?php
    require '../include/footer.php';
  ?>   