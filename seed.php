<?php
   require 'init.php';

   query('delete from product_buy');

   query('alter table product_buy auto_increment=1');
   query('delete from product');

   query('alter table product auto_increment=1');
    
//    $product = [
//     ['category_id'=>1,'name'=>'some','slug'=>slug('some'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'some','slug'=>slug('some'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'some','slug'=>slug('some'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'a','slug'=>slug('a'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'a','slug'=>slug('a'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'a','slug'=>slug('a'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'sony','slug'=>slug('sony'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'sony','slug'=>slug('sony'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'sony','slug'=>slug('sony'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'sony','slug'=>slug('sony'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'sony','slug'=>slug('sony'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//     ['category_id'=>1,'name'=>'sony','slug'=>slug('sony'),'image'=>'image','description'=>'desc','total_quantity'=>2,'sale_price'=>100],
//    ];

//    foreach($product as $p){
//        query("insert into product (category_id,name,slug,image,description,total_quantity,sale_price) values
//         ('{$p['category_id']}','{$p['name']}','{$p['slug']}','{$p['image']}','{$p['description']}','{$p['total_quantity']}','{$p['sale_price']}')
//        ");
//    }

   echo 'product seed';
   