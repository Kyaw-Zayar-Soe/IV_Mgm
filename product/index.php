<?php
  require '../init.php';

  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }
  
  if(isset($_GET['sale'])and !empty($_GET['sale'])){
    $slug = $_GET['product_slug'];
    $product = getOne("select * from product where slug=?",[$slug]);
    
    $sale_date = date('Y-m-d');
    $sale_price = $product->sale_price;
    $total_quantity = $product->total_quantity-1;
    $product_id = $product->id;

    query('update product set total_quantity=? where slug=?',[$total_quantity,$slug]);
    query("insert into product_sale (product_id,sale_price,sale_date) values (?,?,?)",[$product_id,$sale_price,$sale_date]);
    
    setmsg('Sale created success');
    go('index.php');
    die();
  }

  if(isset($_GET['page'])){
    paginateProduct(2);
    die();
  } 
 
  if(isset($_GET['search'])){
    $search = $_GET['search'];
    $product = getAll("select * from product where name like '%$search%' order by id desc limit 2");
  }else{
    $search = "";
    $product = getAll("select * from product order by id desc limit 2");
  }
   
  if(isset($_GET['action'])){
    $slug = $_GET['slug'];
   $res = query('delete from product where slug=?',[$slug]);
    setmsg('Product deleted successful!');
  }
  require '../include/header.php';

?>
  <!-- Breadcamp -->
  <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">

        <span class="text-white">    
          <h4 class="d-inline text-white">Product</h4>
           >All
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
        
        <a href="create.php" class="btn btn-info">Create</a>
        <?php 
           showError();
           showmsg();
              
        ?>
        <form action=""  class="mt-2">
            <input type="text" name="search" value="<?php echo $search; ?>" class="btn btn-sm bg-white">
            <button class=" btn btn-sm btn-primary ">
              <span class="fa fa-search"></span>
            </button>
            <?php
              if(!empty($search)){
                echo '<a href="index.php" class="btn btn-sm btn-danger">Clear Search</a>';
              }
            ?>
        </form>
        
        <table class="table table-striped text-white mt-2">
            <thead>
                <tr>
                    <th>name</th>
                    <th>qty</th>
                    <th>sale price</th>
                    <th>option</th>
                </tr>
            </thead>
            <tbody id="tblData">
              <?php
                 foreach($product as $r){
              ?>
              <tr>
                <td><?php echo $r->name; ?></td>
                <td><?php echo $r->total_quantity; ?></td>
                <td><?php echo $r->sale_price; ?></td>
                <td>
                  <a href="detail.php?slug=<?php echo $r->slug; ?>" class="btn btn-sm btn-success">
                    <span class="fa fa-eye"></span>
                  </a>
                  <a href="edit.php?slug=<?php echo $r->slug; ?>" class="btn btn-sm btn-primary">
                    <span class="fa fa-edit"></span>
                  </a>
                  <a href="index.php?action=delete&slug=<?php echo $r->slug; ?>" class="btn btn-sm btn-danger">
                    <span class="fa fa-trash"></span>
                  </a>
                  <a href="<?php echo $root.'product_buy/index.php?product_slug='.$r->slug; ?>" class="btn btn-sm btn-outline-danger">Buy</a>
                  <a href="index.php?product_slug=<?php echo$r->slug; ?>&sale=true" class="btn btn-sm btn-outline-success">Sale</a>
                  <a href="sale_list.php?product_slug=<?php echo$r->slug; ?>&sale=true" class="btn btn-sm btn-success">Sale List</a>
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
  require("../include/footer.php");
    
?>


<script>
  $(function(){
     var page = 1;
     var tblData = $('#tblData');
     var btnFetch = $('#btnFetch');
     btnFetch.click(function(){
       page += 1;

       var search = "<?php echo $search ?>";
       var url = `index.php?page=${page}`

       if(search){
           url  += `&search=${search}`;
       }
       
       $.get(url).then(function(data){
          const d = JSON.parse(data);
          var htmlString = "";
          if(!d.length){
            btnFetch.attr('disabled','disabled');
          }
          d.map(function(d){
            htmlString += ` <tr>
                <td>${d.name}</td>
                <td>${d.total_quantity}</td>
                <td>${d.sale_price}</td>
                <td>
                  <a href="detail.php?slug=${d.slug}" class="btn btn-sm btn-success">
                    <span class="fa fa-eye"></span>
                  </a>
                  <a href="edit.php?slug=${d.slug}" class="btn btn-sm btn-primary">
                    <span class="fa fa-edit"></span>
                  </a>
                  <a href="index.php?action=delete&slug=${d.slug}" class="btn btn-sm btn-danger">
                    <span class="fa fa-trash"></span>
                  </a>
                  <a href="../product_buy/index.php?product_slug=${d.slug}" class="btn btn-sm btn-outline-danger">Buy</a>
                  <a href="index.php?product_slug=${d.slug}&sale=true" class="btn btn-sm btn-outline-success">Sale</a>
                  <a href="sale_list.php?product_slug=${d.slug}&sale=true" class="btn btn-sm btn-success">Sale List</a>
                </td>
                </td>
              </tr>`
            
          });
          tblData.append(htmlString); 
       })
     })
  })
</script>


