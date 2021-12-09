<?php
  require '../init.php';

  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }

  if(isset($_GET['delete'])){
    $product_slug = $_GET['product_slug'];
    $id = $_GET['id'];
    $product_id = getOne('select product_id from product_sale where id=?',[$id])->product_id;
    query('update product set total_quantity=product.total_quantity+1 where id=?',[$product_id]);
    query('delete from product_sale where id=?',[$id]);
    setmsg('Product sale success!');
    go('sale_list.php?product_slug='.$product_slug);
    die();
     
  }
  
  if(isset($_GET['product_slug'])and !empty($_GET['product_slug'])){
    $slug = $_GET['product_slug'];
    $product = getOne("select * from product where slug=?",[$slug]);
    $sale = getAll('select * from product_sale where product_id=?',[$product->id]);
  }

  
  require '../include/header.php';

?>
  <!-- Breadcamp -->
  <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">

        <span class="text-white">    
        <a href="index.php" class="fas fa-2x fa-chevron-circle-left" ></a>

          <h4 class="d-inline text-white">Product</h4>
          >
          <?php echo $product->name; ?>
           >Sale List
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
        <?php
          showmsg();
          showError();
        ?>
        <table class="table table-striped">
           <tr>
             <td>Sale Price</td>
             <td>Sale date</td>
             <td>Option</td>
           </tr>
           <?php
             foreach($sale as $c){
           ?>
              <tr class="text-white">
              <td><?php echo $c->sale_price; ?></td>
              <td><?php echo $c->sale_date; ?></td>
              <td>
                <a href="sale_list.php?delete=true&id=<?php echo $c->id ?>&product_slug=<?php echo $slug; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Sure!')">
                 <span class="fas fa-trash"></span>
                </a>
              </td>
              </tr>
          <?php
             }
           ?>
        </table>
      </div>
    </div>
  </div>
<?php
  require("../include/footer.php");
    
?>

