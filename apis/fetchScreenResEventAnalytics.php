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

    $screenResAnalyticsArray = fetchScreenResolutionEventAnalytics();
    if($screenResAnalyticsArray){
        echo json_encode(["status"=> "Success", "data"=> $screenResAnalyticsArray]);
    }
    else{
        echo json_encode(["status"=> "Failed", "data"=> "Server Error"]);
    }
?>
