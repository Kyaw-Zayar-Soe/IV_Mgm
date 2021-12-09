<?php
  require '../init.php';

  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }

  
  $cat = getAll('select * from category ');
  if(isset($_GET['slug']) and !empty($_GET['slug'])){
    $slug = $_GET['slug'];
    $product = getOne("select * from product where slug='$slug'");

  if($_SERVER['REQUEST_METHOD'] =='POST'){

    $category_id = $_REQUEST['category_id'];
    $name= $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $sale_price = $_REQUEST['sale_price'];
    $file = $_FILES['image'];
  if(isset($file) and !empty($file['name'])){
    $file_limit_size = 1024*1024*2;
    $file_size = $file['size'];
    if($file_limit_size<$file_size){
      setError('Image must be below 2mb');
    }
     //image upload
    $file_name = slug($file['name']);
    $path = "../image/" . $file_name;
    $tmp = $file['tmp_name'];
    move_uploaded_file($tmp,$path); 
    
    if(file_exists('../image/'.$product->image)){
        unlink('../image/'.$product->image);
      }
     }else{
    $file_name = $product->image;
    }
    $res = query("update product set name='$name',category_id='$category_id',
    description='$description',sale_price='$sale_price',image='$file_name' where slug='$slug'");
    if($res){
      setmsg('Product updated success');
      go('edit.php?slug='.$product->slug);
      die();
    }else{
      setmsg('Product updated fail');
      go('edit.php?slug='.$product->slug);
      die();
    }   
  }
  }else{
    setError('Wrong slug');
    go('index.php');
    die();
  }
  
  
  require("../include/header.php");


?>
  <!-- Breadcamp -->
  <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
        <a href="index.php" class="fas fa-2x fa-chevron-circle-left" ></a>

          <h4 class="d-inline text-white">Product</h4>
          > Edit
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
        <form class="mt-2 row" method="POST" enctype="multipart/form-data">

          <div class="col-12">
            <h4 class="text-white">Product Info:</h4>

              <!-- category_id -->
            <div class="form-group">
              <label>Choose Category</label>
              <select name="category_id" class="form-control">
                <?php 
                   foreach($cat as $c){
                     $selected = $c->id == $product->category_id ? 'selected':'';
                     echo "<option value='{$c->id}' $selected>{$c->name}</option>";
                   }
                ?>
              </select>
            </div>

              <!-- name -->
            <div class="form-group">
              <label>Enter Name</label>
              <input type="text" value="<?php echo $product->name; ?>" class="form-control" name="name">
            </div>

              <!-- image -->
            <div class="form-group">
              <label>Choose Image</label>
              <input type="file" class="form-control" name="image">
              <img src="<?php echo $root.'image/'.$product->image; ?>" width="200px" class="img-thumbnail mt-1">
            </div>

              <!-- description -->
            <div class="form-group">
              <label>Enter Description</label>
              <textarea name="description" class="form-control"><?php echo $product->description; ?></textarea>
            </div>

            <div class="form-group">
              <label>Sale Price</label>
              <input type="number" value="<?php echo $product->sale_price; ?>" class="form-control" name="sale_price">
            </div>

            

          </div>

          
            <div class="col-12">
              <input type="submit" value="Update" class="btn btn-sm btn-warning">
            </div>
        </form>
      </div>
    </div>
  </div>
 
<?php
  require("../include/footer.php");
    
?>
