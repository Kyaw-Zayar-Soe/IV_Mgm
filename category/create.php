<?php
  require '../init.php';
  
  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_REQUEST['name'];

    if(empty($name)){
      setError('Please Enter Name');
    }

    if(!hasError()){
      $res = query('insert into category (slug,name) values (?,?)',[slug($name),$name]);
      if($res){
        setmsg('Category created successfully!');
      }
    }
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
          showmsg();
        ?>
        <form class="mt-3" method="POST">
            <div class="form-group ">
              <label>Enter Name</label>
              <input type="text" name='name' class="form-control">
            </div>
            <input type="submit" value="Create" class="btn btn-sm btn-danger">
        </form>
      </div>
    </div>
  </div>
 
<?php
  require("../include/footer.php");
    
?>
