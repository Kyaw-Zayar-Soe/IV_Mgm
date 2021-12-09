<?php
  require '../init.php';
  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }


  if(isset($_GET['action'])){
    $id = $_GET['id'];
    $product_slug = $_GET['product_slug'];
    $product_data = getOne('select * from product where slug=?',[$product_slug]);
    $product_buy_data = getOne('select * from product_buy where id=?',[$id]);

    $total_qty = $product_data->total_quantity - $product_buy_data->total_quantity;
    
    query('delete from product_buy where id=?',[$id]);
    query("update product set total_quantity=? where slug=?",[$total_qty,$product_slug]);
    setmsg('Product buy deleted!');
    go('index.php?product_slug='.$product_slug);
    die();
    
  }
 
  $product_slug = $_GET['product_slug'];
  $product = getOne("select * from product where slug=?",[$product_slug]);
  $buy = getAll("select * from product_buy where (product_id=?) order by id desc limit 2",[$product->id]);
  
  require("../include/header.php");
?>
  <!-- Breadcamp -->
  <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
        <a href="<?php echo $root.'product/index.php'; ?>" class="fas fa-2x fa-chevron-circle-left" ></a>

          <h4 class="d-inline text-white">Product Buy</h4>
          > All
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
          <a href="create.php?product_slug=<?php echo $product_slug; ?>" class="btn btn-info">Create</a>
          <?php
           showmsg();
           showError();
           ?>
          <table method="POST" class="table table-striped mt-2">
            <thead>
            <tr>
              <td><b>Buy price</b></td>
              <td><b>Toal Qty</b></td>
              <td><b>Buy date</b></td>
              <td>option</td>
            </tr>
            </thead>
            <tbody id="tblData">
            <?php
              foreach($buy as $b){
            ?>
              <tr class="text-white">
               <td><?php echo $b->buy_price; ?></td>
               <td><?php echo $b->total_quantity; ?></td>
               <td><?php echo $b->buy_date; ?></td>
               <td>
                 <a href="index.php?action=delete&product_slug=<?php echo $product_slug; ?>&id=<?php echo $b->id; ?>" 
                 class="btn btn-sm btn-danger" onclick="confirm('Sure?')">
                   <span class="fas fa-trash"></span>
                 </a>
               </td>
              </tr>
            <?php
             }
            ?>
            </tbody>
          </table>
            <div class="text-center">
              <button class="btn btn-warning" id='btnFetch'>
                <span class="fas fa-arrow-down"></span>
              </button>
            </div>
      </div>
    </div>
  </div>
  <?php
    require '../include/footer.php';
  ?>   
  
             
