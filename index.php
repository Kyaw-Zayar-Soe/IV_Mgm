<?php
  require 'init.php';
  if(!isset($_SESSION['user'])){
    setError('Please Login First');
    go('login.php');
  }

  $date = date('Y-m-d');
  $total_sale = getOne('select sum(sale_price)as price from product_sale where sale_date=?',[$date])->price;
  $total_buy = getOne('select sum(buy_price)as price from product_buy where buy_date=?',[$date])->price;
  $net_profit = $total_sale-$total_buy;
  
  $Latest_sale = getAll('select product_sale.*, product.name as product_name 
    from product_sale left join product on product_sale.product_id=product.id 
    where product_sale.sale_date=? order by id desc limit 3',[$date]);

  $Latest_buy = getAll('select product_buy.*, product.name as product_name 
    from product_buy left join product on product_buy.product_id=product.id 
    where product_buy.buy_date=? order by id desc limit 3',[$date]); 

  require("include/header.php");
?>
  
  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
       <div class="row">
        <div class="col-4">
          <div class="card text-center bg-success p-4">
            <div>
              <h5 class="text-white">Total Sale:</h5>
              <h3><span class="badge badge-warning"><?php echo $total_sale; ?></span></h3>
            </div>
          </div>
        </div>

        <div class="col-4">
          <div class="card text-center bg-danger p-4">
            <div>
              <h5 class="text-white">Total Buy:</h5>
              <h3><span class="badge badge-warning"><?php echo $total_buy ?></span></h3>
            </div>
          </div>
        </div>

        <div class="col-4">
          <div class="card text-center bg-primary p-4">
            <div>
              <h5 class="text-white">Net Come:</h5>
              <h3><span class="badge badge-warning"><?php echo $net_profit; ?></span></h3>
            </div>
          </div>
        </div>
        <br><br>
        <hr class="w-100 border border-gray"/>
          <div class="col-6">
            <h4 class="text-success">Latest Sale List</h4>
             <table class="table table-striped">
                 <tr class="text-white">
                   <td>Product</td>
                   <td>Sale</td>
                 </tr>
                 <?php
                   foreach($Latest_sale as $s){
                 ?>
                   <tr class="text-white">
                    <td><?php echo $s->product_name;?></td>
                    <td><?php echo $s->sale_price;?></td>
                   </tr>
                 <?php
                   }
                 ?>
                 
             </table>
          </div>
          <div class="col-6">
            <h4 class="text-success">Latest Buy List</h4>
             <table class="table table-striped">
                 <tr class="text-white">
                   <td>Product</td>
                   <td>Buy</td>
                 </tr>
                 <?php
                   foreach($Latest_buy as $b){
                 ?>
                   <tr class="text-white">
                    <td><?php echo $b->product_name;?></td>
                    <td><?php echo $b->buy_price;?></td>
                   </tr>
                 <?php
                   }
                 ?>
             </table>
          </div>

       </div>
      </div>
    </div>
  </div>
 
<?php
  require("include/footer.php");
    
?>
