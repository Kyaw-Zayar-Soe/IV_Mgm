<?php 
    $conn = new PDO('mysql:host=localhost;dbname=kurotech_pos','root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function query($sql,$params=[]){
        global $conn;
        $res = $conn->prepare($sql);
        return $res->execute($params);
    }

    function getAll($sql,$params=[]){
        global $conn;
        $res = $conn->prepare($sql);
        $res->execute($params);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    function getOne($sql,$params=[]){
        global $conn;
        $res = $conn->prepare($sql);
        $res->execute($params);
        return $res->fetch(PDO::FETCH_OBJ);
    }
    
    // $data = getOne('Select * from users');
    // print_r($data);
    
    
    
    
    // $sql = 'Insert into users (slug,name,email,password) values (?,?,?,?)';
    // $res = $conn->prepare($sql);
    // $res->execute(['slug',
    //               'userone',
    //               'userone@a.com',
    //               password_hash('password', PASSWORD_BCRYPT)
    //               ]);
