<?php
  require '../init.php';
  
  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }
 
  if($_SERVER['REQUEST_METHOD'] =='POST'){
    $slug = $_GET['slug'];
    $name = $_REQUEST['name'];
    query('update category set name=?,slug=? where slug=?',[$name,slug($name),$slug]);
    go('index.php');
}


  if(isset($_GET['slug'])){
      $slug = $_GET['slug'];
      $cat = getOne('select * from category where slug=?',[$slug]);
      if(!$cat){
        setError('Category Not Found');
        go('index.php');
        die();
      }
  }else{
     setError('Category Not Found');
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

          <h4 class="d-inline text-white">Category</h4>
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
        <form class="mt-3" method="POST">
            <div class="form-group ">
              <label>Enter Name</label>
              <input type="text" value="<?php echo $cat->name ?>" name='name' class="form-control">
            </div>
            <input type="submit" value="Update" class="btn btn-sm btn-danger">
        </form>

      </div>
    </div>
  </div>
 
<?php
  require("../include/footer.php");
    
?>
