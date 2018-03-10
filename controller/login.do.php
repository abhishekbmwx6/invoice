<?php

$conn = include('./connection.php');

if($_POST && $_POST["username"] && $_POST['password']){
    $query ="SELECT count(*) as count FROM `login` where username ='".$_POST['username']."' and password='".$_POST['password']."' ";
    $stmt = $conn->prepare($query); 
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; 
    if($result["count"]==1){
        $query ="SELECT l.status,u.* FROM `login` as l inner join `user` as u on l.user_id = u.user_id where l.username ='".$_POST['username']."' and l.password='".$_POST['password']."'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        //user data
        $_SESSION["user"] = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; 
        
        //redirect to home
        header("location: ../home.php");

    }else if($result["count"]==0){
        header("location: ../index.php?error='no user found!'");
    }else{
        header("location: ../index.php?error='invalid username or password'");
    }
}else{
    header("location: ../index.php?error='invalid username or password'");
}
?>