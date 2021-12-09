<?php
  require '../init.php';

  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }

  
  $cat = getAll('select * from category ');
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $category_id = $_REQUEST['category_id'];
      $slug = slug($_REQUEST['name']);
      $name = $_REQUEST['name'];
      $description = $_REQUEST['description'];
      $total_qty = $_REQUEST['total_quantity'];
      $sale_price = $_REQUEST['sale_price'];
      $buy_price = $_REQUEST['buy_price'];
      $buy_date = $_REQUEST['buy_date'];
  
      $file = $_FILES['image'];
      if(empty($file['name'])){
        setError('Please Choose Image');
      }else{
        $file_limit_size = 1024*1024*1;
        $file_size = $file['size'];
        if($file_limit_size<$file_size){
          setError('Image must be below 2mb');
        }

         //image upload
         $file_name = slug($file['name']);
         $path = "../image/" . $file_name;
         $tmp = $file['tmp_name'];
         move_uploaded_file($tmp,$path);  
         
     
        // save to product
         query('insert into product (category_id,slug,name,image,description,total_quantity,sale_price) values (?,?,?,?,?,?,?)',
               [$category_id,$slug,$name,$file_name,$description,$total_qty,$sale_price]);

         $product_id = $conn->lastInsertId();
         
        // save to product buy
         query('insert into product_buy (product_id,total_quantity,buy_price,buy_date) values (?,?,?,?)',
               [$product_id,$total_qty,$buy_price,$buy_date]);

        setmsg('Product created Successful!');
        go('index.php');
        
        // file upload
      }
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
          > New
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
               
         ?>
        <form class="mt-2 row" method="POST" enctype="multipart/form-data">

          <div class="col-6">
            <h4 class="text-white">Product Info:</h4>

              <!-- category_id -->
            <div class="form-group">
              <label>Choose Category</label>
              <select name="category_id" class="form-control">
                <?php 
                   foreach($cat as $c){
                     $selected = $c->id == $product->category_id ?'selected':'';
                     echo "<option value='{$c->id}' $selected>{$c->name}</option>";
                   }
                ?>
              </select>
            </div>

              <!-- name -->
            <div class="form-group">
              <label>Enter Name</label>
              <input type="text" class="form-control" name="name">
            </div>

              <!-- image -->
            <div class="form-group">
              <label>Choose Image</label>
              <input type="file" class="form-control" name="image">
            </div>

              <!-- description -->
            <div class="form-group">
              <label>Enter Description</label>
              <textarea name="description" class="form-control"></textarea>
            </div>
            

          </div>

          <div class="col-6">
            <h4 class="text-white">Inventory</h4>
            
            <span class="text-primary">
              <span class="fas fa-info-circle text-primary"></span> 
              For Sale Info:
            </span>
            <div class="form-group">
              <label>Sale Price</label>
              <input type="number" class="form-control" name="sale_price">
            </div>

            <span class="text-primary">
              <span class="fas fa-info-circle text-primary"></span> 
              For Buy Info:
            </span>
            <div class="form-group">
              <label>Buy Price</label>
              <input type="number" class="form-control" name="buy_price">
            </div>

            <div class="form-group">
              <label>Total Qty</label>
              <input type="number" class="form-control" name="total_quantity">
            </div>

            <div class="form-group">
              <label>Buy Date</label>
              <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="buy_date">
            </div>

          </div>
            <div class="col-12">
              <input type="submit" value="Create" class="btn btn-sm btn-warning">
            </div>
        </form>
      </div>
    </div>
  </div>
 
<?php
  require("../include/footer.php");
    
?>
