<?php
  
   
  function setError($message){
      $_SESSION['errors'] = [];
      $_SESSION['errors'][] = $message;
  }

  function showError(){
      if(isset($_SESSION['errors'])){
        $error = $_SESSION['errors'];
        $_SESSION['errors'] = [];
  
        if(count($error)){
            foreach($error as $e){
  ?>
      <div class="alert alert-danger d-flex align-items-center" role="alert" >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
         <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
          <div><?php echo $e;?></div>
      </div>
  <?php              
            }
      }
     
      }
  }


  function setmsg($message){
    $_SESSION['msg'] = [];
    $_SESSION['msg'][] = $message;
}

function showmsg(){
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        $_SESSION['msg'] = [];
    
        if(isset($_SESSION['msg']) and count($msg)){
            foreach($msg as $e){
    ?>
      <div class="alert alert-dark d-flex align-items-center" role="alert" >
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Success:">
             <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
           </svg>
          <div><?php echo '&nbsp'.$e;?></div>
      </div>
    <?php              
            }
        }
    }
    
}
  function hasError(){
      $error = $_SESSION['errors'];
      if(count($error)){
          return true;
      }
          return false;
  }

  function go($path){
      header("Location:$path");
  }

  function slug($str){
      return uniqid().'-'.str_replace('','-',$str);
  }

  function paginateCategory($record_per_page = 5){
      if(isset($_GET['page'])){
          $page = $_GET['page'];
      }else{
          $page = 2;
      }
      if($page <= 0){
          $page = 2;
      }
      $start = ($page - 1) *$record_per_page;
      $limit = "$start,$record_per_page";
      $data  = getAll("select * from category order by id desc limit $limit");
      echo json_encode($data);
  }

  function paginateProduct($record_per_page = 5){
      if(isset($_GET['page'])){
          $page = $_GET['page'];
      }else{
          $page = 2;
      }
      if($page <= 0){
          $page = 2;
      }
      $start = ($page - 1) * $record_per_page;
      $limit = "$start,$record_per_page";
      $sql = "select * from product ";

      if(isset($_GET['search']) and !empty($_GET['search'])){
          $search = $_GET['search'];
          $sql .= "where name like '%$search%' ";
      }
          $sql .= "order by id desc limit $limit ";
      $data  = getAll($sql);
      echo json_encode($data);
  }

  