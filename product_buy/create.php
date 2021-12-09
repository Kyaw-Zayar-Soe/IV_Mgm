<?php
  require '../init.php';
  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }
  $product_slug = $_GET['product_slug'];
  $product = getOne("select id,total_quantity from product where slug=?",[$product_slug]);

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $buy_price = $_REQUEST['buy_price'];
    $total_quantity = $_REQUEST['total_quantity'];
    $buy_date = $_REQUEST['buy_date'];

    query('insert into product_buy (product_id,total_quantity,buy_price,buy_date) values(?,?,?,?)',
    [$product->id,$total_quantity,$buy_price,$buy_date]);

    $total_qty = $product->total_quantity + $total_quantity;
    query("update product set total_quantity=$total_qty where slug='$product_slug'");

    setmsg('Product buy added');
    go('index.php?product_slug='.$product_slug);
    die();
  }
  require("../include/header.php");
?>
  <!-- Breadcamp -->
  <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">      
          <a href="index.php?product_slug=<?php echo $product_slug; ?>" class="fas fa-2x fa-chevron-circle-left" ></a>
          <h4 class="d-inline text-white">Product</h4>
          > New Product Buy
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
        <?php
          showError();
          showmsg();
        ?>

          <form method="POST">
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
              <input type="submit" value="Create" class="btn btn-sm btn-warning">
          </form>
      </div>
    </div>
  </div>
  <?php
    require '../include/footer.php';
  ?>   