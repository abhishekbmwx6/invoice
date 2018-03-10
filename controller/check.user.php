<?php

$conn = include('./connection.php');
error_reporting(E_ERROR | E_PARSE);
if($_POST && $_POST["contact"]){
    $query ="SELECT * from user where contact ='".$_POST['contact']."'";
    $stmt = $conn->prepare($query); 
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if(sizeof($result)){
        //contact found
        $res->status = "success";
        $res->message = "success";
        $res->data = json_encode($result[0]);
    
        echo json_encode($res);
    }else{
        //contact not found
        $res->status = "error";
        $res->message = "no user found";
        $res->data = [];
    
        echo json_encode($res);
    }
}else{
    //contact not found
    $res->status = "error";
    $res->message = "no user found";
    $res->data = [];

    echo json_encode($res);
}
?>