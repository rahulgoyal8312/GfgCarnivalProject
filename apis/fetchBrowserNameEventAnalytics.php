<?php
    include_once "../dynamoDbFunctions.php";
    session_start();

    if(!@$_POST['csrf_token'] || $_POST['csrf_token'] != $_SESSION['csrf_token']){
        echo json_encode(["status"=> "Failed", "msg"=> "Invalid CSRF Token"]);
        die;
    }
    if(!@$_SESSION['userid'] || $_SESSION['userid'] == ""){
        echo json_encode(["status"=> "Failed", "msg"=> "User not logged in"]);
        die;
    }

    $browserNameArray = fetchAllBrowserNames();
    if($browserNameArray){
        echo json_encode(["status"=> "Success", "data"=> $browserNameArray]);
    }
    else{
        echo json_encode(["status"=> "Failed", "msg"=> "Server Error"]);
    }
?>
